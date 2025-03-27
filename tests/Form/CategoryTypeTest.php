<?php

namespace App\Tests\Form;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Mapping\Loader\AttributeLoader;
use Symfony\Component\Validator\Validation;

class CategoryTypeTest extends TypeTestCase
{
    protected function getExtensions()
    {
        $validator = Validation::createValidatorBuilder()
            ->addLoader(new AttributeLoader())
            ->getValidator();

        return [
            new ValidatorExtension($validator),
        ];
    }

    public function testSubmitValidCategoryDataPopulatesModel()
    {
        $formData = [
            'name' => 'Valid Category',
        ];

        $model = new Category();
        $model->setName('');

        $form = $this->factory->create(CategoryType::class, $model);

        $expected = new Category();
        $expected->setName('Valid Category');

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $model);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    public function testSubmitEmptyCategoryNameShowsError()
    {
        $formData = [
            'name' => '',
        ];

        $form = $this->factory->create(CategoryType::class);
        $form->submit($formData);

        $this->assertFalse($form->isValid());
        $this->assertCount(1, $form->getErrors(true));
    }

    public function testSubmitLongCategoryNameShowsError()
    {
        $formData = [
            'name' => str_repeat('A', 51),
        ];

        $form = $this->factory->create(CategoryType::class);
        $form->submit($formData);

        $this->assertFalse($form->isValid());
        $this->assertCount(1, $form->getErrors(true));
    }
}