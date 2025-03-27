<?php

namespace App\Tests\Entity;

use App\Entity\City;
use PHPUnit\Framework\TestCase;

class CityTest extends TestCase
{
    public function testNameCanBeSetAndRetrieved()
    {
        $city = new City();
        $city->setName('Example City');
        $this->assertEquals('Example City', $city->getName());
    }

    public function testIdIsInitiallyNull()
    {
        $city = new City();
        $this->assertNull($city->getId());
    }

    public function testNameCannotBeNull()
    {
        $this->expectException(\TypeError::class);
        $city = new City();
        $city->setName(null);
    }

    public function testZipcodeCannotBeNull()
    {
        $this->expectException(\TypeError::class);
        $city = new City();
        $city->setZipcode(null);
    }
}