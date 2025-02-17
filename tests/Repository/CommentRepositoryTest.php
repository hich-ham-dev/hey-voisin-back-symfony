<?php

namespace App\Tests\Repository;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;

class CommentRepositoryTest extends TestCase
{
    public function testFindReturnsCommentById()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(CommentRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['find'])
            ->getMock();
        $comment = new Comment();
        $repository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($comment);
        $result = $repository->find(1);
        $this->assertEquals($comment, $result);
    }

    public function testFindOneByReturnsCommentByCriteria()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(CommentRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['findOneBy'])
            ->getMock();
        $comment = new Comment();
        $repository->expects($this->once())
            ->method('findOneBy')
            ->with(['content' => 'example'])
            ->willReturn($comment);
        $result = $repository->findOneBy(['content' => 'example']);
        $this->assertEquals($comment, $result);
    }

    public function testFindAllReturnsArrayOfComments()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(CommentRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['findAll'])
            ->getMock();
        $comments = [new Comment(), new Comment()];
        $repository->expects($this->once())
            ->method('findAll')
            ->willReturn($comments);
        $result = $repository->findAll();
        $this->assertCount(2, $result);
        $this->assertContainsOnlyInstancesOf(Comment::class, $result);
    }

    public function testFindByReturnsArrayOfCommentsByCriteria()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(CommentRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['findBy'])
            ->getMock();
        $comments = [new Comment(), new Comment()];
        $repository->expects($this->once())
            ->method('findBy')
            ->with(['content' => 'example'])
            ->willReturn($comments);
        $result = $repository->findBy(['content' => 'example']);
        $this->assertCount(2, $result);
        $this->assertContainsOnlyInstancesOf(Comment::class, $result);
    }
}