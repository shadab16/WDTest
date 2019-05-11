<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    public function create(PostService $postService)
    {
        $post = $postService->create('', '', 'Sample Title', 'Sample Content');
        return $this->render('post-admin-edit.html.twig', [
            'post' => $post
        ]);
    }

    public function edit(string $postId, PostService $postService)
    {
        $post = $postService->getPostById($postId);
        return $this->render('post-admin-edit.html.twig', [
            'post' => $post
        ]);
    }

    public function save(PostService $postService)
    {
        return $this->render('post-admin-save.html.twig', [
            'post' => []
        ]);
    }

    public function delete(string $postId, PostService $postService)
    {
        return $this->render('post-admin-delete.html.twig', [
            'postId' => $postId
        ]);
    }
}
