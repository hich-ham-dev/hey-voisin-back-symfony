<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class UserRepositoryTest extends TestCase
{
    public function testUpgradePasswordThrowsExceptionForUnsupportedUser()
    {
        $this->expectException(UnsupportedUserException::class);
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = new UserRepository($registry);
        $unsupportedUser = $this->createMock(PasswordAuthenticatedUserInterface::class);
        $repository->upgradePassword($unsupportedUser, 'new_hashed_password');
    }

    public function testFindReturnsUserById()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(UserRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['find'])
            ->getMock();
        $user = new User();
        $repository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($user);
        $result = $repository->find(1);
        $this->assertEquals($user, $result);
    }

    public function testFindOneByReturnsUserByCriteria()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(UserRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['findOneBy'])
            ->getMock();
        $user = new User();
        $repository->expects($this->once())
            ->method('findOneBy')
            ->with(['username' => 'example'])
            ->willReturn($user);
        $result = $repository->findOneBy(['username' => 'example']);
        $this->assertEquals($user, $result);
    }

    public function testFindAllReturnsArrayOfUsers()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(UserRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['findAll'])
            ->getMock();
        $users = [new User(), new User()];
        $repository->expects($this->once())
            ->method('findAll')
            ->willReturn($users);
        $result = $repository->findAll();
        $this->assertCount(2, $result);
        $this->assertContainsOnlyInstancesOf(User::class, $result);
    }

    public function testFindByReturnsArrayOfUsersByCriteria()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(UserRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['findBy'])
            ->getMock();
        $users = [new User(), new User()];
        $repository->expects($this->once())
            ->method('findBy')
            ->with(['username' => 'example'])
            ->willReturn($users);
        $result = $repository->findBy(['username' => 'example']);
        $this->assertCount(2, $result);
        $this->assertContainsOnlyInstancesOf(User::class, $result);
    }
}