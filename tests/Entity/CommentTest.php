<?php

namespace App\Tests\Entity;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    public function testTitleCanBeSetAndRetrieved()
    {
        $comment = new Comment();
        $comment->setTitle('Example Title');
        $this->assertEquals('Example Title', $comment->getTitle());
    }

    public function testContentCanBeSetAndRetrieved()
    {
        $comment = new Comment();
        $comment->setContent('Example Content');
        $this->assertEquals('Example Content', $comment->getContent());
    }

    public function testPublishedAtCanBeSetAndRetrieved()
    {
        $comment = new Comment();
        $date = new \DateTimeImmutable();
        $comment->setPublishedAt($date);
        $this->assertEquals($date, $comment->getPublishedAt());
    }

    public function testUpdatedAtCanBeSetAndRetrieved()
    {
        $comment = new Comment();
        $date = new \DateTimeImmutable();
        $comment->setUpdatedAt($date);
        $this->assertEquals($date, $comment->getUpdatedAt());
    }

    public function testUserCanBeSetAndRetrieved()
    {
        $comment = new Comment();
        $user = new User();
        $comment->setUser($user);
        $this->assertEquals($user, $comment->getUser());
    }

    public function testPostCanBeSetAndRetrieved()
    {
        $comment = new Comment();
        $post = new Post();
        $comment->setPost($post);
        $this->assertEquals($post, $comment->getPost());
    }

    public function testIdIsInitiallyNull()
    {
        $comment = new Comment();
        $this->assertNull($comment->getId());
    }

    public function testTitleCannotBeNull()
    {
        $this->expectException(\TypeError::class);
        $comment = new Comment();
        $comment->setTitle(null);
    }

    public function testContentCannotBeNull()
    {
        $this->expectException(\TypeError::class);
        $comment = new Comment();
        $comment->setContent(null);
    }

    public function testPublishedAtCannotBeNull()
    {
        $this->expectException(\TypeError::class);
        $comment = new Comment();
        $comment->setPublishedAt(null);
    }
}