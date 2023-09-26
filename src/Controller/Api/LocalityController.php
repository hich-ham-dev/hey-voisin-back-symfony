<?php

namespace App\Controller\Api;

use App\Repository\LocalityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/api')]
class LocalityController extends AbstractController
{
    #[Route('/locality', name: 'app_api_locality')]
    public function index(LocalityRepository $locality): JsonResponse
    {
        $localities = $locality->findAll();

        return $this->json($localities, Response::HTTP_OK, [], ['groups' => 'localities']);
    }

    #[Route('/locality/{id}', name: 'app_api_locality_show', methods: ['GET'])]
    public function show(LocalityRepository $locality, int $id): JsonResponse
    {
        $locality = $locality->find($id);

        return $this->json($locality, Response::HTTP_OK, [], ['groups' => 'localities']);
    }
  
}
