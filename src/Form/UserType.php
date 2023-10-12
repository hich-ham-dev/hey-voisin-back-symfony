<?php

namespace App\Form;

use App\Entity\Avatar;
use App\Entity\City;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email'
            ])
            ->add('roles', ChoiceType::class,[
                "choices" => [
                    "Administrateur" => "ROLE_ADMIN",
                    "Modérateur" => "ROLE_MODERATOR",
                    "Utilisateur" => "ROLE_USER"
                ],
                "multiple" => true,
                "expanded" => true,
                "label" => "Privilèges"
            ])
            ->add('alias', TextType::class, [
                'label' => 'Alias'
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse'
            ])
            ->add('avatar', EntityType::class, [
                'class' => Avatar::class,
                'choice_label' => 'name',
            ])
            ->add('city', EntityType::class, [
                'label' => 'Ville',
                'class' => City::class,
                'choice_label' => 'name',
            ]);
            if($options["custom_option"] !== "edit"){
                $builder
                ->add('password',RepeatedType::class,[
                    "type" => PasswordType::class,
                    "first_options" => ["label" => "Rentrez un mot de passe","help" => "Le mot de passe doit avoir minimum 4 caractères"],
                    "second_options" => ["label" => "Confirmez le mot de passe"],
                    "invalid_message" => "Les champs doivent être identiques"
                ]);
            }
        ;
    }        

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            "custom_option" => "default"
        ]);
    }
}
