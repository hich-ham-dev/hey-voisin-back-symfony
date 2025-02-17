<?php

namespace App\Tests\Entity;

use App\Entity\Avatar;
use PHPUnit\Framework\TestCase;
class AvatarTest extends TestCase
{
    public function testUrlCanBeSetAndRetrieved()
    {
        $avatar = new Avatar();
        $avatar->setUrl('https://www.example.com/avatar.jpg');
        $this->assertEquals('https://www.example.com/avatar.jpg', $avatar->getUrl());
    }

    public function testNameCanBeSetAndRetrieved()
    {
        $avatar = new Avatar();
        $avatar->setName('avatar.jpg');
        $this->assertEquals('avatar.jpg', $avatar->getName());
    }

    public function testIdIsNullByDefault()
    {
        $avatar = new Avatar();
        $this->assertNull($avatar->getId());
    }

    public function testUrlCannotBeNull()
    {
        $this->expectException(\TypeError::class);
        $avatar = new Avatar();
        $avatar->setUrl(null);
    }

    public function testNameCannotBeNull()
    {
        $this->expectException(\TypeError::class);
        $avatar = new Avatar();
        $avatar->setName(null);
    }
}