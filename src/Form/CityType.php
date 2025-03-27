<?php

namespace App\Form;

use App\Entity\City;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le nom ne peut pas être vide'
                    ]),
                    new Assert\Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Le nom doit faire au moins {{ limit }} caractères',
                        'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères'
                    ])
                ]
            ])
            ->add('zipcode', TextType::class, [
                'label' => 'Code postal',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le code postal ne peut pas être vide'
                    ]),
                    new Assert\Length([
                        'min' => 5,
                        'max' => 10,
                        'minMessage' => 'Le code postal doit faire au moins {{ limit }} caractères',
                        'maxMessage' => 'Le code postal ne peut pas dépasser {{ limit }} caractères'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => City::class,
        ]);
    }
}
