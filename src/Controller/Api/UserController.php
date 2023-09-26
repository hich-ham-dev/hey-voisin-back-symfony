<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
