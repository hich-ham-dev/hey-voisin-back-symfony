<?php

namespace App\Controller\Api;

use App\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CityController extends AbstractController
{
    #[Route('/api/city', name: 'app_api_city', methods:['GET'])]
    public function index(CityRepository $city): JsonResponse
    {
        $cities = $city->findAll();
        
        return $this->json($cities, Response::HTTP_OK, [], ['groups' => 'cities']);
    }

    #[Route('/api/city/{id}', name: 'app_api_city_show', methods:['GET'])]
    public function show(CityRepository $city, int $id): JsonResponse
    {
        $city = $city->find($id);

        return $this->json($city, Response::HTTP_OK, [], ['groups' => 'cities']);
    }
}
