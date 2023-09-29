<?php

namespace App\Controller\Api;

use App\Entity\Avatar;
use App\Entity\City;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/api')]
class UserController extends AbstractController
{
    #[Route('/user', name: 'app_api_user', methods: ['GET'])]
    public function index(UserRepository $user): JsonResponse
    {
        $users = $user->findAll();

        return $this->json($users, Response::HTTP_OK, [], ['groups' => 'users']);
    }

    #[Route('/user/{id}', name: 'app_api_user_show', methods: ['GET'])]
    public function show(UserRepository $user, int $id): JsonResponse
    {
        $user = $user->find($id);

        return $this->json($user, Response::HTTP_OK, [], ['groups' => 'users']);
    }
    
    #[Route('/user/new', name: 'app_api_user_new', methods: ['POST'])]
    public function new(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $manager): JsonResponse
    {   
        $user = new User;
        $data = json_decode($request->getContent(), true);
        $avatarId = $data['avatar']['id'];
        $avatar = $manager->getRepository(Avatar::class)->find($avatarId);
        $cityId = $data['city']['id'];
        $city = $manager->getRepository(City::class)->find($cityId);
        
        
        $user->setEmail($data['email']);
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($passwordHasher->hashPassword($user, $data['password']));
        $user->setAlias($data['alias']);
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setAvatar($avatar);
        $user->setAddress($data['address']);
        $user->setCity($city);
    

        $manager->persist($user);
        $manager->flush();

        return $this->json(['message' => 'Merci de vous être inscrit !'], Response::HTTP_OK);
    }



}
