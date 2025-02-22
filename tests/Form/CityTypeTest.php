<?php

namespace App\Tests\Form;

use App\Entity\City;
use App\Form\CityType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Mapping\Loader\AttributeLoader;
use Symfony\Component\Validator\Validation;

class CityTypeTest extends TypeTestCase
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

    public function testSubmitValidCityDataPopulatesModel()
    {
        $formData = [
            'name' => 'Valid City',
            'zipcode' => '12345',
        ];

        $model = new City();
        $model->setName('');
        $model->setZipcode('');

        $form = $this->factory->create(CityType::class, $model);

        $expected = new City();
        $expected->setName('Valid City');
        $expected->setZipcode('12345');

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $model);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    public function testSubmitEmptyCityNameShowsError()
    {
        $formData = [
            'name' => '',
            'zipcode' => '12345',
        ];

        $form = $this->factory->create(CityType::class);
        $form->submit($formData);

        $this->assertFalse($form->isValid());
        $this->assertCount(1, $form->getErrors(true));
    }

    public function testSubmitEmptyZipcodeShowsError()
    {
        $formData = [
            'name' => 'Valid City',
            'zipcode' => '',
        ];

        $form = $this->factory->create(CityType::class);
        $form->submit($formData);

        $this->assertFalse($form->isValid());
        $this->assertCount(1, $form->getErrors(true));
    }

    public function testSubmitLongCityNameShowsError()
    {
        $formData = [
            'name' => str_repeat('A', 256),
            'zipcode' => '12345',
        ];

        $form = $this->factory->create(CityType::class);
        $form->submit($formData);

        $this->assertFalse($form->isValid());
        $this->assertCount(1, $form->getErrors(true));
    }

    public function testSubmitInvalidZipcodeShowsError()
    {
        $formData = [
            'name' => 'Valid City',
            'zipcode' => 'invalid-zipcode',
        ];

        $form = $this->factory->create(CityType::class);
        $form->submit($formData);

        $this->assertFalse($form->isValid());
        $this->assertCount(1, $form->getErrors(true));
    }
}