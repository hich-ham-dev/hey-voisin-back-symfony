<?php

namespace App\Controller\Api;

use App\Entity\User;
use PhpParser\Builder\Method;
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
    #[Route('/user', name: 'app_api_user')]
    public function index(UserRepository $user): JsonResponse
    {
        $users = $user->findAll();

        return $this->json($users, Response::HTTP_OK, [], ['groups' => 'users']);
    }

    #[Route('/user/{id}', name: 'app_api_user_show')]
    public function show(UserRepository $user, int $id): JsonResponse
    {
        $user = $user->find($id);

        return $this->json($user, Response::HTTP_OK, [], ['groups' => 'users']);
    }
 //! WIP en attente de refonte de la BDD------------------------------------------------------------------
   /* #[Route('/user/new', name: 'app_api_user_new', Methods: ['POST'])]
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $manager): JsonResponse
    {   
        $data = json_decode($request->getContent(), true);
        //$locality = $manager->getRepository(Locality::class)->find($data['locality']);
        $user = new User;
        
        $user->setEmail($data['email']);
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->$passwordHasher->hashPassword($user, $data['password']));
        $user->setAlias($data['alias']);
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setAvatar($data['avatar']);

        $manager->persist($user);
        $manager->flush();

        return $this->json(['message' => 'Merci de vous être inscrit !'], Response::HTTP_OK);
    }*/
 //! WIP en attente de refonte de la BDD------------------------------------------------------------------


}
