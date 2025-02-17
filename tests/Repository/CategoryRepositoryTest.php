<?php

namespace App\Tests\Repository;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;

class CategoryRepositoryTest extends TestCase
{
    public function testFindReturnsCategoryById()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(CategoryRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['find'])
            ->getMock();
        $category = new Category();
        $repository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($category);
        $result = $repository->find(1);
        $this->assertEquals($category, $result);
    }

    public function testFindOneByReturnsCategoryByCriteria()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(CategoryRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['findOneBy'])
            ->getMock();
        $category = new Category();
        $repository->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => 'example'])
            ->willReturn($category);
        $result = $repository->findOneBy(['name' => 'example']);
        $this->assertEquals($category, $result);
    }

    public function testFindAllReturnsArrayOfCategories()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(CategoryRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['findAll'])
            ->getMock();
        $categories = [new Category(), new Category()];
        $repository->expects($this->once())
            ->method('findAll')
            ->willReturn($categories);
        $result = $repository->findAll();
        $this->assertCount(2, $result);
        $this->assertContainsOnlyInstancesOf(Category::class, $result);
    }

    public function testFindByReturnsArrayOfCategoriesByCriteria()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $repository = $this->getMockBuilder(CategoryRepository::class)
            ->setConstructorArgs([$registry])
            ->onlyMethods(['findBy'])
            ->getMock();
        $categories = [new Category(), new Category()];
        $repository->expects($this->once())
            ->method('findBy')
            ->with(['name' => 'example'])
            ->willReturn($categories);
        $result = $repository->findBy(['name' => 'example']);
        $this->assertCount(2, $result);
        $this->assertContainsOnlyInstancesOf(Category::class, $result);
    }
}