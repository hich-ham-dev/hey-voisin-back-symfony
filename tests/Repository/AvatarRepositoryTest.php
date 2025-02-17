<?php

namespace App\Tests\Repository;

use App\Entity\Avatar;
use App\Repository\AvatarRepository;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;

class AvatarRepositoryTest extends TestCase
{
    public function testFindReturnsAvatarById()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(AvatarRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['find'])
            ->getMock();
        $avatar = new Avatar();
        $repository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($avatar);
        $result = $repository->find(1);
        $this->assertEquals($avatar, $result);
    }

    public function testFindOneByReturnsAvatarByCriteria()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(AvatarRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['findOneBy'])
            ->getMock();
        $avatar = new Avatar();
        $repository->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => 'example'])
            ->willReturn($avatar);
        $result = $repository->findOneBy(['name' => 'example']);
        $this->assertEquals($avatar, $result);
    }

    public function testFindAllReturnsArrayOfAvatars()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(AvatarRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['findAll'])
            ->getMock();
        $avatars = [new Avatar(), new Avatar()];
        $repository->expects($this->once())
            ->method('findAll')
            ->willReturn($avatars);
        $result = $repository->findAll();
        $this->assertCount(2, $result);
        $this->assertContainsOnlyInstancesOf(Avatar::class, $result);
    }

    public function testFindByReturnsArrayOfAvatarsByCriteria()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(AvatarRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['findBy'])
            ->getMock();
        $avatars = [new Avatar(), new Avatar()];
        $repository->expects($this->once())
            ->method('findBy')
            ->with(['name' => 'example'])
            ->willReturn($avatars);
        $result = $repository->findBy(['name' => 'example']);
        $this->assertCount(2, $result);
        $this->assertContainsOnlyInstancesOf(Avatar::class, $result);
    }
}