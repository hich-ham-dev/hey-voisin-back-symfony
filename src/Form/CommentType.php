<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu'
            ])
            ->add('publishedAt', DateTimeType::class, [
                'label' => 'Date de publication'
            ])
            ->add('updatedAt', DateTimeType::class, [
                'label' => 'Date de mise à jour'
            ])
            ->add('posts', PostType::class, [
                'label' => 'Publication'
            ])
            ->add('users', UserType::class, [
                'label' => 'Utilisateur'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
