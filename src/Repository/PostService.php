<?php

namespace App\Repository;
use Doctrine\DBAL\Driver\Connection;

class PostService
{
    protected $connection;
    protected $userService;

    public function __construct(Connection $connection, UserService $userService)
    {
        $this->connection = $connection;
        $this->userService = $userService;
    }

    public static function create(string $postId, string $authorId, string $title, string $content)
    {
        $post = new \App\Entity\Post();
        return $post->setPostId($postId)
            ->setAuthorId($authorId)
            ->setTitle($title)
            ->setContent($content);
    }

    public function getPostById(string $id)
    {
        echo '<pre>';
        print_r($this->userService->getPermissionsByUser(1)); die;

        $stmt = $this->connection->prepare('SELECT * FROM post WHERE post_id = ?');
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $record = $stmt->fetch();
        if (empty($record))
        {
            throw new \RangeException('Unable to find post with the given ID');
        }
        return self::create($record['post_id'], $record['author_id'], $record['title'], $record['content']);
    }

    public function getAllPosts()
    {
        $records = $this->connection->fetchAll('SELECT * FROM post');
        $posts = [];
        foreach ($records as $record) {
            $posts[] = self::create($record['post_id'], $record['author_id'], $record['title'], $record['content']);
        }
        return $posts;
    }

    public function getAllowedPosts(User $user)
    {
        return [];
    }

    public function savePost(Post $post)
    {
        return null;
    }

    public function deletePost(string $postId)
    {
        return null;
    }
}
