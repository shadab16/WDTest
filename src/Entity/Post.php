<?php

namespace App\Entity;

class Post
{
    static $STATUS_DRAFT = 0;
    static $STATUS_PUBLISHED = 1;
    static $STATUS_SCHEDULED = 2; // Later
    static $STATUS_ABANDONED = 3; // Later
    static $STATUS_DELETED = 4;

    private $postId;
    private $authorId;
    private $title;
    private $content;
    private $version;
    private $createdOn;
    private $modifiedOn;
    private $status;

    public function getPostId()
    {
        return $this->postId;
    }

    public function setPostId(string $postId)
    {
        $this->postId = $postId;
        return $this;
    }

    public function getAuthorId()
    {
        return $this->authorId;
    }

    public function setAuthorId(string $authorId)
    {
        $this->authorId = $authorId;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
        return $this;
    }
}
