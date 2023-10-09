<?php

namespace App\Controller\Api;

use App\Entity\City;
use App\Entity\User;
use App\Entity\Avatar;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/api')]
class UserController extends AbstractController
{
    #[Route('/user', name: 'app_api_user', methods: ['GET'])]
    public function index(UserRepository $user): JsonResponse
    {
        // On utilise le UserRepository pour récupérer tous les utilisateurs
        $users = $user->findAll();
    
        // On renvoie les utilisateurs en tant que réponse JSON avec le code HTTP 200 OK
        return $this->json($users, Response::HTTP_OK, [], ['groups' => 'users']);
    }
    
    #[Route('/user/{id}', name: 'app_api_user_show', methods: ['GET'])]
    public function show(UserRepository $user, int $id): JsonResponse
    {
        // On utilise le UserRepository pour trouver un utilisateur par son ID
        $user = $user->find($id);
    
        // On renvoie l'utilisateur trouvé en tant que réponse JSON avec le code HTTP 200 OK
        return $this->json($user, Response::HTTP_OK, [], ['groups' => 'users']);
    }
    
    #[Route('/user', name: 'app_api_user_new', methods: ['POST'])]
    public function new(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $manager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {   
        // On récupère les données JSON de la requête et on les transforme en tableau associatif
        $data = json_decode($request->getContent(), true);
        
        // On essaie de désérialiser les données JSON en un objet de la classe User
        try {
            $userSerialize = $serializer->deserialize($request->getContent(), User::class, 'json', [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['city', 'avatar']
            ]);
        } catch (NotEncodableValueException) {
            // En cas d'échec de la désérialisation, on retourne une réponse d'erreur
            return $this->json(['error' => "Il semble y avoir un problème !"], Response::HTTP_BAD_REQUEST);
        }
    
        // On valide l'objet User avec le Validator
        $errors = $validator->validate($userSerialize);
    
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
        
        // On crée un nouvel utilisateur
        $user = new User;
    
        // On récupère l'identifiant de l'avatar depuis les données JSON
        $avatarId = $data['avatar'];
        // On trouve l'avatar correspondant dans la base de données
        $avatar = $manager->getRepository(Avatar::class)->find($avatarId);
    
        // On récupère l'identifiant de la ville depuis les données JSON
        $cityId = $data['city'];
        // On trouve la ville correspondante dans la base de données
        $city = $manager->getRepository(City::class)->find($cityId);
        
        // On associe les propriétés de l'utilisateur avec les données JSON
        $user->setEmail($data['email']);
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($passwordHasher->hashPassword($user, $data['password']));
        $user->setAlias($data['alias']);
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setAvatar($avatar);
        $user->setAddress($data['address']);
        $user->setCity($city);
    
        // On persiste et on enregistre l'objet User en base de données
        $manager->persist($user);
        $manager->flush();
    
        // On retourne un message de succès en tant que réponse JSON avec le code HTTP 201 OK
        return $this->json(['message' => 'Merci de vous être inscrit !'], Response::HTTP_CREATED, [], ['groups' => 'users']);
    }    
}
