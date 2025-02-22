<?php

namespace App\Tests\Repository;

use App\Entity\City;
use App\Repository\CityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;

class CityRepositoryTest extends TestCase
{
    public function testFindReturnsCityById()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(CityRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['find'])
            ->getMock();
        $city = new City();
        $repository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($city);
        $result = $repository->find(1);
        $this->assertEquals($city, $result);
    }

    public function testFindOneByReturnsCityByCriteria()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(CityRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['findOneBy'])
            ->getMock();
        $city = new City();
        $repository->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => 'example'])
            ->willReturn($city);
        $result = $repository->findOneBy(['name' => 'example']);
        $this->assertEquals($city, $result);
    }

    public function testFindAllReturnsArrayOfCities()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(CityRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['findAll'])
            ->getMock();
        $cities = [new City(), new City()];
        $repository->expects($this->once())
            ->method('findAll')
            ->willReturn($cities);
        $result = $repository->findAll();
        $this->assertCount(2, $result);
        $this->assertContainsOnlyInstancesOf(City::class, $result);
    }

    public function testFindByReturnsArrayOfCitiesByCriteria()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(CityRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['findBy'])
            ->getMock();
        $cities = [new City(), new City()];
        $repository->expects($this->once())
            ->method('findBy')
            ->with(['name' => 'example'])
            ->willReturn($cities);
        $result = $repository->findBy(['name' => 'example']);
        $this->assertCount(2, $result);
        $this->assertContainsOnlyInstancesOf(City::class, $result);
    }
}