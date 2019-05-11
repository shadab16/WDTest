<?php

namespace App\Repository;
use Doctrine\DBAL\Driver\Connection;
use App\Entity\Post;

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

    public function getAllowedPosts(string $userId)
    {
        $stmt = $this->connection->prepare('SELECT * FROM post WHERE author_id = ?');
        $stmt->bindValue(1, $userId);
        $stmt->execute();
        $records = $stmt->fetchAll();
        $posts = [];
        foreach ($records as $record) {
            $posts[] = self::create($record['post_id'], $record['author_id'], $record['title'], $record['content']);
        }
        return $posts;
    }

    public function savePost(Post $post)
    {
        $this->connection->insert('post', [
            'post_id' => null,
            'author_id' => $post->getAuthorId(),
            'title' => $post->getTitle(),
            'content' => $post->getContent(),
            'created_on' => time(),
            'version' => 1,
            'status' => Post::$STATUS_PUBLISHED
        ]);
        return $this->connection->lastInsertId();
    }

    public function updatePost(Post $post)
    {
        $this->connection->update('post', [
            'title' => $post->getTitle(),
            'content' => $post->getContent(),
            'modified_on' => time()
        ], [
            'post_id' => $post->getPostId()
        ]);
    }

    public function deletePost(string $postId)
    {
        return null;
    }
}
