<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function new(EntityManagerInterface $manager, Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        // ! WIP : à revoir après refonte de la BDD
        // $data = json_decode($request->getContent(), true);

        // try {
        //     $post = $serializer->deserialize($request->getContent(), Post::class, 'json');
        // } catch (NotEncodableValueException) {
        //     return $this->json(['error' => "json invalide"], Response::HTTP_BAD_REQUEST);
        // }

        // $errors = $validator->validate($post);

        // if (count($errors) > 0) {

        //     foreach ($errors as $error) {
        //         $dataErrors[$error->getPropertyPath()][] = $error->getMessage();
        //     }

        //     return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        // }

        // $categoryName = $data['category']['name'];
        // $category = $manager->getRepository(Category::class)->findOneBy(['name' => $categoryName]);
        // $localityCity = $data['locality'];
        // $locality = $manager->getRepository(Locality::class)->findOneBy(['city' => $localityCity]);
        // $userAlias = $data['user']['alias'];
        // $user = $manager->getRepository(User::class)->findOneBy(['alias' => $userAlias]);

        // $post = new Post();
        // $post->setTitle($data['title']);
        // $post->setResume($data['resume']);
        // $post->setIsActive($data['is_active']);
        // $post->setIsOffer($data['is_offer']);
        // $post->setPublishedAt(new \DateTimeImmutable($data['published_at']));
        // $post->setUpdatedAt(new \DateTimeImmutable($data['updated_at']));
        // $post->setCategory($category);
        // $post->setLocality($locality);
        // $post->setUser($user);

        // $manager->persist($post);
        // $manager->flush();
        
        $jsonContent = $request->getContent();

        try {
            $post = $serializer->deserialize($jsonContent, Post::class, 'json');
        } catch (NotEncodableValueException) {
            return $this->json(['error' => "json invalide"], Response::HTTP_BAD_REQUEST);
        }

        $errors = $validator->validate($post);

        if (count($errors) > 0) {

            foreach ($errors as $error) {
                $dataErrors[$error->getPropertyPath()][] = $error->getMessage();
            }

            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // $postRepository->add($post, true);


        return $this->json(['message' => 'Create a new post'], Response::HTTP_OK);
    }
}
