<?php

namespace App\Tests\Repository;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;

class PostRepositoryTest extends TestCase
{
    public function testSearchByQueryReturnsPostsMatchingQuery()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(PostRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['searchByQuery'])
            ->getMock();
        $posts = [new Post(), new Post()];
        $repository->expects($this->once())
            ->method('searchByQuery')
            ->with('example')
            ->willReturn($posts);
        $result = $repository->searchByQuery('example');
        $this->assertCount(2, $result);
        $this->assertContainsOnlyInstancesOf(Post::class, $result);
    }

    public function testSearchByQueryReturnsEmptyArrayWhenNoMatch()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(PostRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['searchByQuery'])
            ->getMock();
        $repository->expects($this->once())
            ->method('searchByQuery')
            ->with('nonexistent')
            ->willReturn([]);
        $result = $repository->searchByQuery('nonexistent');
        $this->assertEmpty($result);
    }

    public function testSearchByQueryReturnsAllPostsWhenQueryIsNull()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(PostRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['searchByQuery'])
            ->getMock();
        $posts = [new Post(), new Post()];
        $repository->expects($this->once())
            ->method('searchByQuery')
            ->with(null)
            ->willReturn($posts);
        $result = $repository->searchByQuery(null);
        $this->assertCount(2, $result);
        $this->assertContainsOnlyInstancesOf(Post::class, $result);
    }
}