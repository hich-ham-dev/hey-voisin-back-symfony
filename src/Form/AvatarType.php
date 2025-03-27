<?php

namespace App\Form;

use App\Entity\Avatar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class AvatarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', TextType::class, [
                'label' => 'URL de l\'avatar',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'L\'URL ne peut pas être vide'
                    ]),
                    new Assert\Url([
                        'message' => 'L\'URL n\'est pas valide',
                        'requireTld' => true,
                    ]),
                    new Assert\Length([
                        'max' => 2100,
                        'maxMessage' => 'L\'URL ne peut pas dépasser {{ limit }} caractères',
                    ])
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'avatar',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le nom ne peut pas être vide'
                    ]),
                    new Assert\Length([
                        'min' => 2,
                        'max' => 25,
                        'minMessage' => 'Le nom doit faire au moins {{ limit }} caractères',
                        'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Avatar::class,
        ]);
    }
}
