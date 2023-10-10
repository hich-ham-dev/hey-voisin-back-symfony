<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('resume', TextareaType::class, [
                'label' => 'Résumé'
            ])
            ->add('is_active', CheckboxType::class, [
                'label' => 'Actif'
            ])
            ->add('is_offer', CheckboxType::class, [
                'label' => 'Offre'
            ])
            ->add('published_at', DateTimeType::class, [
                'label' => 'Date de publication'
            ])
            ->add('updated_at', DateTimeType::class, [
                'label' => 'Date de mise à jour'
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'alias',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
