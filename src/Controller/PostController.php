<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PostService;

class PostController extends AbstractController
{
    public function index(PostService $postService)
    {
        $posts = $postService->getAllPosts();
        return $this->render('post-index.html.twig', [
            'posts' => $posts
        ]);
    }

    public function view(string $postId, PostService $postService)
    {
        $post = $postService->getPostById($postId);
        return $this->render('post-view.html.twig', [
            'post' => $post
        ]);
    }
}
