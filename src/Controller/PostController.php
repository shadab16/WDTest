<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PostService;
use App\Repository\PostPermissionService;

class PostController extends AbstractController
{
    private $postService;
    private $postPermissionService;

    public function __construct(PostService $postService, PostPermissionService $postPermissionService)
    {
        $this->postService = $postService;
        $this->postPermissionService = $postPermissionService;
    }

    public function index()
    {
        if ($this->postPermissionService->canViewAny())
        {
            $posts = $this->postService->getAllPosts();
        }
        else
        {
            // FIXME: Get logged-in user from session
            $posts = $posts = $this->postService->getAllowedPosts(2);
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
