<?php

namespace App\Controller\Api;

use App\Repository\AvatarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class AvatarController extends AbstractController
{
    #[Route('/avatar', name: 'app_api_avatar')]
    public function index(AvatarRepository $avatar): JsonResponse
    {
        $avatars = $avatar->findAll();

        return $this->json($avatars, Response::HTTP_OK, [], ['groups' => 'avatars']);
    }

    #[Route('/avatar/{id}', name: 'app_api_avatar_show')]
    public function show(AvatarRepository $avatar, int $id): JsonResponse
    {
        $avatar = $avatar->find($id);

        return $this->json($avatar, Response::HTTP_OK, [], ['groups' => 'avatars']);
    }
}
