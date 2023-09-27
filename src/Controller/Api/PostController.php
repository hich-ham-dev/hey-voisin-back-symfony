<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Entity\Locality;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;    
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/post/new', name: 'app_api_post_new', methods: ['POST'])]
    public function new(EntityManagerInterface $manager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $categoryId = $data['category'];
        $category = $manager->getRepository(Category::class)->find($categoryId);
        $localityId = $data['locality'];
        $locality = $manager->getRepository(Locality::class)->find($localityId);
        $userId = $data['user'];
        $user = $manager->getRepository(User::class)->find($userId);

        $post = new Post();
        $post->setTitle($data['title']);
        $post->setResume($data['resume']);
        $post->setIsActive($data['is_active']);
        $post->setIsOffer($data['is_offer']);
        $post->setPublishedAt(new \DateTimeImmutable($data['published_at']));
        $post->setUpdatedAt(new \DateTimeImmutable($data['updated_at']));
        $post->setCategory($data['category']);
        $post->setLocality($data['locality']);
        $post->setUser($data['user']);

        $manager->persist($post);
        $manager->flush();

        return $this->json(['message' => 'Create a new post'], Response::HTTP_OK);
    }
}
