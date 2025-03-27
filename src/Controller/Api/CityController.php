<?php

namespace App\Controller\Api;

use App\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class CityController extends AbstractController
{
    #[Route('/cities', name: 'app_api_city', methods:['GET'])]
    public function index(CityRepository $city): JsonResponse
    {
        // Get all cities
        $cities = $city->findAll();
        
        return $this->json($cities, Response::HTTP_OK, [], ['groups' => 'cities']);
    }

    #[Route('/cities/{id}', name: 'app_api_city_show', methods:['GET'])]
    public function show(CityRepository $city, int $id): JsonResponse
    {
        // Get one city by id
        $city = $city->find($id);

        return $this->json($city, Response::HTTP_OK, [], ['groups' => 'cities']);
    }

    #[Route('/cities/{id}/posts', name: 'app_api_city_posts', methods:['GET'])]
    public function getPosts(CityRepository $city, int $id): JsonResponse
    {
        // Get one city by id
        $city = $city->find($id);

        // Get all posts from city
        $posts = $city->getPosts();

        return $this->json($posts, Response::HTTP_OK, [], ['groups' => 'posts']);
    }
}
