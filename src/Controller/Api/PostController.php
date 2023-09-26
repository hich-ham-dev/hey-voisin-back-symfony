<?php

namespace App\Controller\Api;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class PostController extends AbstractController
{
    
    #[Route('/post', name: 'app_api_post', methods: ['GET'])]
    public function index(PostRepository $post): JsonResponse
    {
        $posts = $post->findAll();
        
        return $this->json($posts, Response::HTTP_OK, [], ['groups' => 'posts']);
    }

    #[Route('/post/{id}', name: 'app_api_post_show', methods: ['GET'])]
    public function show(PostRepository $post, int $id): JsonResponse
    {
        $post = $post->find($id);

        return $this->json($post, Response::HTTP_OK, [], ['groups' => 'posts']);
    }
}
