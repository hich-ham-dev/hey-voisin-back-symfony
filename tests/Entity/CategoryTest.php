<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Entity\Post;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testNameCanBeSetAndRetrieved()
    {
        $category = new Category();
        $category->setName('Category 1');
        $this->assertEquals('Category 1', $category->getName());
    }

    public function testIdIsNullByDefault()
    {
        $category = new Category();
        $this->assertNull($category->getId());
    }

    public function testNameCannotBeNull()
    {
        $this->expectException(\TypeError::class);
        $category = new Category();
        $category->setName(null);
    }

    public function testPostsIsInitializedAsEmptyCollection()
    {
        $category = new Category();
        $this->assertEmpty($category->getPosts());
    }

    public function testPostCanBeAddedToCategory()
    {
        $category = new Category();
        $post = new Post();
        $category->addPost($post);
        $this->assertContains($post, $category->getPosts());
    }

    public function testPostCanBeRemovedFromCategory()
    {
        $category = new Category();
        $post = new Post();
        $category->addPost($post);
        $category->removePost($post);
        $this->assertFalse($category->getPosts()->contains($post));
        $this->assertNull($post->getCategory());
    }
}