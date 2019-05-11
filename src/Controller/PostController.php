<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\PostService;
use App\Repository\PostPermissionService;

class PostController extends AbstractController
{
    private $postService;
    private $postPermissionService;
    private $session;

    public function __construct(PostService $postService, PostPermissionService $postPermissionService, SessionInterface $session)
    {
        $this->postService = $postService;
        $this->postPermissionService = $postPermissionService;
        $this->session = $session;

        if (empty($this->session->get('userId')))
        {
            throw new \RuntimeException('No logged-in user present');
        }
    }

    public function index()
    {
        if ($this->postPermissionService->canViewAny())
        {
            $posts = $this->postService->getAllPosts();
        }
        else
        {
            $loggedUserId = $this->session->get('userId');
            $posts = $posts = $this->postService->getAllowedPosts($loggedUserId);
        }
        return $this->render('post-index.html.twig', [
            'posts' => $posts
        ]);
    }

    public function view(string $postId, PostService $postService)
    {
        $post = $this->postService->getPostById($postId);
        if (!$this->postPermissionService->canView($post))
        {
            throw new \RuntimeException('Cannot view post with the mentioned ID');
        }
        return $this->render('post-view.html.twig', [
            'post' => $post
        ]);
    }
}
