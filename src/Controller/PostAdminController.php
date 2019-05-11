<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\PostService;
use App\Repository\PostPermissionService;

class PostAdminController extends AbstractController
{
    private $session;
    private $postService;
    private $postPermissionService;

    public function __construct(PostService $postService, PostPermissionService $postPermissionService, SessionInterface $session)
    {
        $this->postService = $postService;
        $this->postPermissionService = $postPermissionService;
        $this->session = $session;
    }

    public function index()
    {
        if ($this->postPermissionService->canEditAny())
        {
            $posts = $this->postService->getAllPosts();
        }
        else
        {
            $loggedUserId = $this->session->get('userId');
            $posts = $posts = $this->postService->getAllowedPosts($loggedUserId);
        }
        return $this->render('post-admin-index.html.twig', [
            'posts' => $posts,
            'canDeletePosts' => true
        ]);
    }

    public function create(Request $request)
    {
        $post = new \App\Entity\Post();

        $loggedUserId = $this->session->get('userId');
        $post->setAuthorId($loggedUserId);

        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Post'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $post = $form->getData();
            $this->postService->savePost($post);
            return $this->redirectToRoute('post_admin_list');
        }

        $saveUrl = $this->generateUrl('post_admin_create');
        return $this->render('post-admin-edit.html.twig', [
            'form' => $form->createView(),
            'post' => $post,
            'saveUrl' => $saveUrl
        ]);
    }

    public function edit(string $postId, Request $request)
    {
        $post = $this->postService->getPostById($postId);

        if (!$this->postPermissionService->canEdit($post))
        {
            throw new \RuntimeException('Cannot edit post with the mentioned ID');
        }

        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Save Post'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $post = $form->getData();
            $this->postService->updatePost($post);
            return $this->redirectToRoute('post_admin_list');
        }

        $saveUrl = $this->generateUrl('post_admin_edit', [
            'postId' => $postId
        ]);
        return $this->render('post-admin-edit.html.twig', [
            'form' => $form->createView(),
            'post' => $post,
            'saveUrl' => $saveUrl
        ]);

    }

    public function delete(string $postId)
    {
        $post = $this->postService->getPostById($postId);
        if (!$this->postPermissionService->canDelete($post))
        {
            throw new \RuntimeException('Cannot delete post with the mentioned ID');
        }

        $this->postService->deletePost($post);
        return $this->render('post-admin-delete.html.twig', [
            'postId' => $postId
        ]);
    }
}
