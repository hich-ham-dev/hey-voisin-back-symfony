<?php

namespace App\Controller\Api;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/api/post', name: 'app_api_post')]
    public function index(PostRepository $post): JsonResponse
    {
        $posts = $post->findAll();
        return $this->json($posts);
    }
}
