<?php

namespace App\Tests\Form;

use App\Entity\Avatar;
use App\Form\AvatarType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Mapping\Loader\AttributeLoader;
use Symfony\Component\Validator\Validation;

class AvatarTypeTest extends TypeTestCase
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

    public function testSubmitValidDataPopulatesModel()
    {
        $formData = [
            'url' => 'http://example.com/avatar.png',
            'name' => 'Example Avatar',
        ];

        $model = new Avatar();
        $model->setUrl('');
        $model->setName('');

        $form = $this->factory->create(AvatarType::class, $model);

        $expected = new Avatar();
        $expected->setUrl('http://example.com/avatar.png');
        $expected->setName('Example Avatar');

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $model);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    public function testSubmitInvalidDataShowsErrors()
    {
        $formData = [
            'url' => '',
            'name' => '',
        ];

        $form = $this->factory->create(AvatarType::class);
        $form->submit($formData);

        $this->assertFalse($form->isValid());
        $this->assertCount(2, $form->getErrors(true));
    }

    public function testSubmitPartialDataPopulatesModel()
    {
        $formData = [
            'url' => 'http://example.com/avatar.png',
            'name' => 'Valid Name',
        ];

        $model = new Avatar();
        $model->setUrl('');
        $model->setName('');

        $form = $this->factory->create(AvatarType::class, $model);

        $expected = new Avatar();
        $expected->setUrl('http://example.com/avatar.png');
        $expected->setName('Valid Name');

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $model);
    }

    public function testSubmitEmptyDataShowsErrors()
    {
        $formData = [];

        $form = $this->factory->create(AvatarType::class);
        $form->submit($formData);

        $this->assertFalse($form->isValid());
        $this->assertCount(2, $form->getErrors(true));
    }

    public function testSubmitInvalidUrlShowsError()
    {
        $formData = [
            'url' => 'invalid-url',
            'name' => 'Example Avatar',
        ];

        $form = $this->factory->create(AvatarType::class);
        $form->submit($formData);

        $this->assertFalse($form->isValid());
        $this->assertCount(1, $form->getErrors(true));
    }

    public function testSubmitShortNameShowsError()
    {
        $formData = [
            'url' => 'http://example.com/avatar.png',
            'name' => 'A',
        ];

        $form = $this->factory->create(AvatarType::class);
        $form->submit($formData);

        $this->assertFalse($form->isValid());
        $this->assertCount(1, $form->getErrors(true));
    }

    public function testSubmitLongNameShowsError()
    {
        $formData = [
            'url' => 'http://example.com/avatar.png',
            'name' => str_repeat('A', 256),
        ];

        $form = $this->factory->create(AvatarType::class);
        $form->submit($formData);

        $this->assertFalse($form->isValid());
        $this->assertCount(1, $form->getErrors(true));
    }
}