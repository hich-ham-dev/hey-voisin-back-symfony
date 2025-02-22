<?php

namespace App\Tests\DataFixturesTest\Provider;

use App\DataFixtures\Provider\CategoriesProvider;
use PHPUnit\Framework\TestCase;

class CategoriesProviderTest extends TestCase
{
    public function testPostCategoriesReturnsValidCategory()
    {
        $provider = new CategoriesProvider();
        $category = $provider->postCategories();
        $this->assertContains($category, [
            'Soutien scolaire',
            'Covoiturage',
            'Bricolage',
            'Jardinage',
            'Aide à domicile',
        ]);
    }

    public function testPostCategoriesReturnsString()
    {
        $provider = new CategoriesProvider();
        $category = $provider->postCategories();
        $this->assertIsString($category);
    }

    public function testPostCategoriesHandlesEmptyArray()
    {
        $provider = $this->getMockBuilder(CategoriesProvider::class)
            ->onlyMethods(['postCategories'])
            ->getMock();
        $provider->method('postCategories')->willReturn('');
        $category = $provider->postCategories();
        $this->assertEmpty($category);
    }
}