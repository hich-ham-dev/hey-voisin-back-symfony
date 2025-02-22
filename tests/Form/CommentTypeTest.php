<?php

namespace App\Tests\Form;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\DoctrineTestHelper;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Mapping\Loader\AttributeLoader;
use Symfony\Component\Validator\Validation;

class CommentTypeTest extends TypeTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        $this->entityManager = DoctrineTestHelper::createTestEntityManager();
        parent::setUp();
    }

    protected function getExtensions()
    {
        $entityType = new EntityType($this->entityManager);

        $validator = Validation::createValidatorBuilder()
            ->addLoader(new AttributeLoader())
            ->getValidator();

        return [
            new PreloadedExtension([$entityType], []),
            new ValidatorExtension($validator),
        ];
    }

    public function testSubmitValidCommentDataPopulatesModel()
    {
        $formData = [
            'title' => 'Valid Title',
            'content' => 'Valid Content',
            'post' => $this->createMock(Post::class),
            'user' => $this->createMock(User::class),
        ];

        $model = new Comment();
        $model->setTitle('');
        $model->setContent('');
        $model->setPost(null);
        $model->setUser(null);

        $form = $this->factory->create(CommentType::class, $model);

        $expected = new Comment();
        $expected->setTitle('Valid Title');
        $expected->setContent('Valid Content');
        $expected->setPost($formData['post']);
        $expected->setUser($formData['user']);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $model);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    public function testSubmitEmptyTitleShowsError()
    {
        $formData = [
            'title' => '',
            'content' => 'Valid Content',
            'post' => $this->createMock(Post::class),
            'user' => $this->createMock(User::class),
        ];

        $form = $this->factory->create(CommentType::class);
        $form->submit($formData);

        $this->assertFalse($form->isValid());
        $this->assertCount(1, $form->getErrors(true));
    }

    public function testSubmitEmptyContentShowsError()
    {
        $formData = [
            'title' => 'Valid Title',
            'content' => '',
            'post' => $this->createMock(Post::class),
            'user' => $this->createMock(User::class),
        ];

        $form = $this->factory->create(CommentType::class);
        $form->submit($formData);

        $this->assertFalse($form->isValid());
        $this->assertCount(1, $form->getErrors(true));
    }

    public function testSubmitEmptyPostShowsError()
    {
        $formData = [
            'title' => 'Valid Title',
            'content' => 'Valid Content',
            'post' => null,
            'user' => $this->createMock(User::class),
        ];

        $form = $this->factory->create(CommentType::class);
        $form->submit($formData);

        $this->assertFalse($form->isValid());
        $this->assertCount(1, $form->getErrors(true));
    }

    public function testSubmitEmptyUserShowsError()
    {
        $formData = [
            'title' => 'Valid Title',
            'content' => 'Valid Content',
            'post' => $this->createMock(Post::class),
            'user' => null,
        ];

        $form = $this->factory->create(CommentType::class);
        $form->submit($formData);

        $this->assertFalse($form->isValid());
        $this->assertCount(1, $form->getErrors(true));
    }
}