<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Entity\City;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class PostController extends AbstractController
{
    
    #[Route('/post', name: 'app_api_post', methods: ['GET'])]
    public function index(PostRepository $post): JsonResponse
    {
        // On utilise le PostRepository pour récupérer tous les posts
        $posts = $post->findAll();
        
        // On renvoie les posts en tant que réponse JSON avec le code HTTP 200 OK
        return $this->json($posts, Response::HTTP_OK, [], ['groups' => 'posts']);
    }
    
    #[Route('/post/{id}', name: 'app_api_post_show', methods: ['GET'])]
    public function show(PostRepository $post, int $id): JsonResponse
    {
        // On utilise le PostRepository pour trouver un post par son ID
        $post = $post->find($id);
    
        // On renvoie le post trouvé en tant que réponse JSON avec le code HTTP 200 OK
        return $this->json($post, Response::HTTP_OK, [], ['groups' => 'posts']);
    }
    
    #[Route('/post/new', name: 'app_api_post_new', methods: ['POST'])]
    public function new(EntityManagerInterface $manager, Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        // On récupère les données JSON de la requête et on les transforme en tableau associatif
        $data = json_decode($request->getContent(), true);
    
        // On essaie de désérialiser les données JSON en un objet de la classe Post
        try {
            $post = $serializer->deserialize($request->getContent(), Post::class, 'json', [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['category', 'city', 'user']
            ]);
        } catch (NotEncodableValueException) {
            // En cas d'échec de la désérialisation, on retourne une réponse d'erreur
            return $this->json(['error' => "json invalide"], Response::HTTP_BAD_REQUEST);
        }
    
        // On valide l'objet Post avec le Validator
        $errors = $validator->validate($post);
    
        // Si des erreurs de validation sont trouvées
        if (count($errors) > 0) {
            $dataErrors = [];
    
            // On récupère les détails des erreurs et on les stocke dans $dataErrors
            foreach ($errors as $error) {
                $dataErrors[$error->getPropertyPath()][] = $error->getMessage();
            }
    
            // On retourne une réponse d'erreur avec les détails des erreurs de validation
            return $this->json($dataErrors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    
        // On récupère l'identifiant de la catégorie depuis les données JSON
        $categoryId = $data['category'];
        
        // On utilise le EntityManager pour trouver la catégorie correspondante
        $category = $manager->getRepository(Category::class)->find($categoryId);
    
        // On associe la catégorie à l'objet Post
        $post->setCategory($category);
    
        // On persiste et on enregistre l'objet Post en base de données
        $manager->persist($post);
        $manager->flush();
        
        // On retourne une réponse JSON avec l'objet Post créé et le code HTTP 201 Created
        return $this->json($post, Response::HTTP_CREATED, [], ['groups' => 'posts']);
    }
    
}