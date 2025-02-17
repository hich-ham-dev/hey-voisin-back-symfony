<?php

namespace App\Tests\Entity;

use App\Entity\Avatar;
use App\Entity\City;
use App\Entity\Post;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testEmailCanBeSetAndRetrieved()
    {
        $user = new User();
        $user->setEmail('example@example.com');
        $this->assertEquals('example@example.com', $user->getEmail());
    }

    public function testRolesCanBeSetAndRetrieved()
    {
        $user = new User();
        $roles = ['ROLE_ADMIN', 'ROLE_USER'];
        $user->setRoles($roles);
        $this->assertEquals($roles, $user->getRoles());
    }

    public function testPasswordCanBeSetAndRetrieved()
    {
        $user = new User();
        $user->setPassword('hashed_password');
        $this->assertEquals('hashed_password', $user->getPassword());
    }

    public function testAliasCanBeSetAndRetrieved()
    {
        $user = new User();
        $user->setAlias('exampleAlias');
        $this->assertEquals('exampleAlias', $user->getAlias());
    }

    public function testFirstnameCanBeSetAndRetrieved()
    {
        $user = new User();
        $user->setFirstname('John');
        $this->assertEquals('John', $user->getFirstname());
    }

    public function testLastnameCanBeSetAndRetrieved()
    {
        $user = new User();
        $user->setLastname('Doe');
        $this->assertEquals('Doe', $user->getLastname());
    }

    public function testAvatarCanBeSetAndRetrieved()
    {
        $user = new User();
        $avatar = new Avatar();
        $user->setAvatar($avatar);
        $this->assertEquals($avatar, $user->getAvatar());
    }

    public function testAddressCanBeSetAndRetrieved()
    {
        $user = new User();
        $user->setAddress('123 Main St');
        $this->assertEquals('123 Main St', $user->getAddress());
    }

    public function testCityCanBeSetAndRetrieved()
    {
        $user = new User();
        $city = new City();
        $user->setCity($city);
        $this->assertEquals($city, $user->getCity());
    }

    public function testPostsCanBeAddedAndRetrieved()
    {
        $user = new User();
        $post = new Post();
        $user->addPost($post);
        $this->assertTrue($user->getPost()->contains($post));
    }

    public function testPostsCanBeRemoved()
    {
        $user = new User();
        $post = new Post();
        $user->addPost($post);
        $user->removePost($post);
        $this->assertFalse($user->getPost()->contains($post));
    }
}