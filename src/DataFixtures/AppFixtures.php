<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker; 
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{   
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher; 
    }

    /**
     * Fonction qui va s'exécuter quand on va charger les fixtures (envoyer les données en BDD)
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        // Instanciation de Faker avec localisation en français
        $faker = \Faker\Factory::create('fr_FR');

        $admin = new User;
        $admin->setAlias($faker->alias());
        $admin->setEmail("admin@gmail.com");
        $admin->setPassword($this->passwordHasher->hashPassword($admin, "admin"));
        $admin->setFirstname($faker->firstName());
        $admin->setLastname($faker->lastName());
        $admin->setRoles(["ROLE_ADMIN"]);

        $manager->persist($admin);

        $manager->flush();
    }
}
