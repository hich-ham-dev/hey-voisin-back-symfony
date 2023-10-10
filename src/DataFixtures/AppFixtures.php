<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\DataFixtures\Provider\CategoriesProvider;
use App\Entity\Avatar;
use App\Entity\City;
use App\Entity\Comment;
use DateTimeImmutable;

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

        // Instanciation de CategoriesProvider
        $categoriesProvider = new CategoriesProvider();

        // Création de 5 avatars
        $avatarList = [];

        for ($a = 1; $a <= 5; $a++) {

            $avatar = new Avatar;

            $avatar->setUrl($faker->imageUrl());
            $avatar->setName($faker->name());
            $avatarList[] = $avatar;
            $manager->persist($avatar);
        }


        // Création de 10 villes
        $citiesList = [];

        for ($c = 1; $c <= 10; $c++) {

            $city = new City;

            $city->setName($faker->city());
            $postcode = str_replace(' ', '', $faker->postcode());
            $city->setZipcode($postcode);
            $citiesList[] = $city;

            $manager->persist($city);
        }


        // Création d'un administrateur
        $admin = new User;

        $admin->setEmail("admin@gmail.com");
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, "admin"));
        $admin->setAlias($faker->name());
        $admin->setFirstname($faker->firstName());
        $admin->setLastname($faker->lastName());
        $admin->setAvatar($avatarList[array_rand($avatarList)]);
        $admin->setAddress($faker->streetAddress());
        $admin->setCity($citiesList[array_rand($citiesList)]);

        $manager->persist($admin);


        // Création d'un modérateur
        $moderator = new User;

        $moderator->setEmail("moderator@gmail.com");
        $moderator->setRoles(["ROLE_MODERATOR"]);
        $moderator->setPassword($this->passwordHasher->hashPassword($moderator, "moderator"));
        $moderator->setAlias($faker->name());
        $moderator->setFirstname($faker->firstName());
        $moderator->setLastname($faker->lastName());
        $moderator->setAvatar($avatarList[array_rand($avatarList)]);
        $moderator->setAddress($faker->streetAddress());
        $moderator->setCity($citiesList[array_rand($citiesList)]);

        $manager->persist($moderator);


        // Création de 20 utilisateurs
        $userList = [];

        for ($u = 1; $u <= 20; $u++) {

            $user = new User;
            //! ATTENTION LE CHAMP EMAIL REQUIERT UNE REVIEW 
            $user->setEmail($faker->email());
            $user->setRoles(["ROLE_USER"]);
            $user->setPassword($this->passwordHasher->hashPassword($user, "user"));
            $user->setAlias($faker->name());
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setAvatar($avatarList[array_rand($avatarList)]);
            $user->setAddress($faker->streetAddress());
            $user->setCity($citiesList[array_rand($citiesList)]);

            $userList[] = $user;

            $manager->persist($user);
        }


        // Création de 5 catégories
        $categoryList = [];

        for ($c = 1; $c <= 5; $c++) {

            $category = new Category;

            $category->setName($categoriesProvider->postCategories());
            $categoryList[] = $category;

            $manager->persist($category);
        }


        // Création de 15 posts
        $postList = [];

        for ($p = 1; $p <= 15; $p++) {

            $post = new Post;

            $post->setTitle($faker->sentence(4));
            $post->setResume($faker->paragraph());
            $publishedAt = new DateTimeImmutable($faker->dateTimeBetween('-6 months')->format('Y-m-d H:i:s'));
            $post->setPublishedAt($publishedAt);
            $post->setIsActive($faker->boolean());
            $post->setIsOffer($faker->boolean());
            $post->setCategory($categoryList[array_rand($categoryList)]);
            $post->setUser($userList[array_rand($userList)]);
            $post->setCity($citiesList[array_rand($citiesList)]);

            $postList[] = $post;

            $manager->persist($post);
        }

        // Création de 30 commentaires
        $commentList = [];

        for ($c = 1; $c <= 30; $c++) {

            $comment = new Comment;

            $comment->setTitle($faker->sentence(2));
            $comment->setContent($faker->paragraph());
            $comment->setPublishedAt(new DateTimeImmutable($faker->dateTimeBetween('-6 months')->format('Y-m-d H:i:s')));
            $comment->setPost($postList[array_rand($postList)]);
            $comment->setUser($userList[array_rand($userList)]);

            $commentList[] = $comment;

            $manager->persist($comment);
        }

        $manager->flush();
    }
}
