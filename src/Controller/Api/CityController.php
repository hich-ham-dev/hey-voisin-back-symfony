<?php

namespace App\Controller\Api;

use App\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class CityController extends AbstractController
{   
    #[Route('/city', name: 'app_api_city')]
    public function index(CityRepository $city): JsonResponse
    {
      $city = $city->findAll();
      return $this->json($city, Response::HTTP_OK, [], ['groups' => 'city']);
    }
}
