<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Entity\City;
use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function testTitleCanBeSetAndRetrieved()
    {
        $post = new Post();
        $post->setTitle('Example Title');
        $this->assertEquals('Example Title', $post->getTitle());
    }

    public function testResumeCanBeSetAndRetrieved()
    {
        $post = new Post();
        $post->setResume('Example Resume');
        $this->assertEquals('Example Resume', $post->getResume());
    }

    public function testIsActiveCanBeSetAndRetrieved()
    {
        $post = new Post();
        $post->setIsActive(true);
        $this->assertTrue($post->isIsActive());
    }

    public function testIsOfferCanBeSetAndRetrieved()
    {
        $post = new Post();
        $post->setIsOffer(true);
        $this->assertTrue($post->isIsOffer());
    }

    public function testPublishedAtCanBeSetAndRetrieved()
    {
        $post = new Post();
        $date = new \DateTimeImmutable();
        $post->setPublishedAt($date);
        $this->assertEquals($date, $post->getPublishedAt());
    }

    public function testUpdatedAtCanBeSetAndRetrieved()
    {
        $post = new Post();
        $date = new \DateTimeImmutable();
        $post->setUpdatedAt($date);
        $this->assertEquals($date, $post->getUpdatedAt());
    }

    public function testCategoryCanBeSetAndRetrieved()
    {
        $post = new Post();
        $category = new Category();
        $post->setCategory($category);
        $this->assertEquals($category, $post->getCategory());
    }

    public function testUserCanBeSetAndRetrieved()
    {
        $post = new Post();
        $user = new User();
        $post->setUser($user);
        $this->assertEquals($user, $post->getUser());
    }

    public function testCommentsCanBeAddedAndRetrieved()
    {
        $post = new Post();
        $comment = new Comment();
        $post->addComment($comment);
        $this->assertTrue($post->getComments()->contains($comment));
    }

    public function testCommentsCanBeRemoved()
    {
        $post = new Post();
        $comment = new Comment();
        $post->addComment($comment);
        $post->removeComment($comment);
        $this->assertFalse($post->getComments()->contains($comment));
    }

    public function testCityCanBeSetAndRetrieved()
    {
        $post = new Post();
        $city = new City();
        $post->setCity($city);
        $this->assertEquals($city, $post->getCity());
    }
}