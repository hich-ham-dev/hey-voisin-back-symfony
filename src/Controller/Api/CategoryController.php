<?php

namespace App\Controller\Api;


use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/api/category', name: 'app_api_category')]
    public function index(CategoryRepository $category): JsonResponse
    {
        $categories = $category->findAll();

        return $this->json($categories, Response::HTTP_OK, [], ['groups' => 'categories']);
    }
}
