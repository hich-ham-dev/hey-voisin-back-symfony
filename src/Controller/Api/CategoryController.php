<?php

namespace App\Controller\Api;


use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_api_category', methods: ['GET'])]
    public function index(CategoryRepository $category): JsonResponse
    {
        $categories = $category->findAll();

        return $this->json($categories, Response::HTTP_OK, [], ['groups' => 'categories', 'posts']);
    }

    #[Route('/category/{id}', name: 'app_api_post_show' , methods: ['GET'])]
    public function show(CategoryRepository $category, int $id): JsonResponse
    {
        $category = $category->find($id);

        return $this->json($category, Response::HTTP_OK, [], ['groups' => 'categories']);
    }
}
