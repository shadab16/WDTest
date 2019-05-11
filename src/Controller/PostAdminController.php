<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\PostService;

class PostAdminController extends AbstractController
{
    public function index(PostService $postService)
    {
        $posts = $postService->getAllPosts();
        return $this->render('post-admin-index.html.twig', [
            'posts' => $posts
        ]);
    }

    public function create(Request $request, PostService $postService)
    {
        $post = new \App\Entity\Post();
        $post->setAuthorId(2);

        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Save Post'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $post = $form->getData();
            $postService->savePost($post);
            return $this->redirectToRoute('post_admin_list');
        }

        $saveUrl = $this->generateUrl('post_admin_create');
        return $this->render('post-admin-edit.html.twig', [
            'form' => $form->createView(),
            'post' => $post,
            'saveUrl' => $saveUrl
        ]);
    }

    public function edit(string $postId, PostService $postService)
    {
        $post = $postService->getPostById($postId);
        $saveUrl = $this->generateUrl('post_admin_edit', [
            'postId' => $postId
        ]);
        return $this->render('post-admin-edit.html.twig', [
            'post' => $post,
            'saveUrl' => $saveUrl
        ]);
    }

    public function delete(string $postId, PostService $postService)
    {
        $postService->deletePost($postId);
        return $this->render('post-admin-delete.html.twig', [
            'postId' => $postId
        ]);
    }
}
