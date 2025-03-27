<?php

namespace App\Tests\DataFixturesTest;

use App\DataFixtures\AppFixtures;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixturesTest extends TestCase
{
    public function testLoadFixturesCreatesCorrectNumberOfEntities()
    {
        $manager = $this->createMock(ObjectManager::class);
        $manager->expects($this->exactly(87))->method('persist');
        $manager->expects($this->once())->method('flush');

        $fixture = new AppFixtures($this->createMock(UserPasswordHasherInterface::class));
        $fixture->load($manager);
    }

    public function testLoadFixturesCreatesAdminWithCorrectRole()
    {
        $manager = $this->createMock(ObjectManager::class);
        $manager->method('persist')->willReturnCallback(function ($entity) use (&$admin) {
            if ($entity instanceof User && in_array('ROLE_ADMIN', $entity->getRoles())) {
                $admin = $entity;
            }
        });

        $fixture = new AppFixtures($this->createMock(UserPasswordHasherInterface::class));
        $fixture->load($manager);

        $this->assertNotNull($admin);
        $this->assertEquals('admin@gmail.com', $admin->getEmail());
    }

    public function testLoadFixturesCreatesModeratorWithCorrectRole()
    {
        $manager = $this->createMock(ObjectManager::class);
        $manager->method('persist')->willReturnCallback(function ($entity) use (&$moderator) {
            if ($entity instanceof User && in_array('ROLE_MODERATOR', $entity->getRoles())) {
                $moderator = $entity;
            }
        });

        $fixture = new AppFixtures($this->createMock(UserPasswordHasherInterface::class));
        $fixture->load($manager);

        $this->assertNotNull($moderator);
        $this->assertEquals('moderator@gmail.com', $moderator->getEmail());
    }

    public function testLoadFixturesCreatesUsersWithCorrectRole()
    {
        $manager = $this->createMock(ObjectManager::class);
        $users = [];
        $manager->method('persist')->willReturnCallback(function ($entity) use (&$users) {
            if ($entity instanceof User && in_array('ROLE_USER', $entity->getRoles())) {
                $users[] = $entity;
            }
        });

        $fixture = new AppFixtures($this->createMock(UserPasswordHasherInterface::class));
        $fixture->load($manager);

        $this->assertCount(22, $users);
    }

    public function testLoadFixturesCreatesCategories()
    {
        $manager = $this->createMock(ObjectManager::class);
        $categories = [];
        $manager->method('persist')->willReturnCallback(function ($entity) use (&$categories) {
            if ($entity instanceof Category) {
                $categories[] = $entity;
            }
        });

        $fixture = new AppFixtures($this->createMock(UserPasswordHasherInterface::class));
        $fixture->load($manager);

        $this->assertCount(5, $categories);
    }

    public function testLoadFixturesCreatesPosts()
    {
        $manager = $this->createMock(ObjectManager::class);
        $posts = [];
        $manager->method('persist')->willReturnCallback(function ($entity) use (&$posts) {
            if ($entity instanceof Post) {
                $posts[] = $entity;
            }
        });

        $fixture = new AppFixtures($this->createMock(UserPasswordHasherInterface::class));
        $fixture->load($manager);

        $this->assertCount(15, $posts);
    }

    public function testLoadFixturesCreatesComments()
    {
        $manager = $this->createMock(ObjectManager::class);
        $comments = [];
        $manager->method('persist')->willReturnCallback(function ($entity) use (&$comments) {
            if ($entity instanceof Comment) {
                $comments[] = $entity;
            }
        });

        $fixture = new AppFixtures($this->createMock(UserPasswordHasherInterface::class));
        $fixture->load($manager);

        $this->assertCount(30, $comments);
    }
}