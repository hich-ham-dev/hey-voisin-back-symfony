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
        $users = $user->findAll();

        return $this->json($users, Response::HTTP_OK, [], ['groups' => 'users']);
    }

    #[Route('/user/{id}', name: 'app_api_user_show', methods: ['GET'])]
    public function show(UserRepository $user, int $id): JsonResponse
    {
        $user = $user->find($id);

        return $this->json($user, Response::HTTP_OK, [], ['groups' => 'users']);
    }
    
    #[Route('/user/new', name: 'app_api_user_new', methods: ['POST'])]
    public function new(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $manager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {   
        
        $data = json_decode($request->getContent(), true);
        
        try {
            $userSerialize = $serializer->deserialize($request->getContent(), User::class, 'json', [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['city', 'avatar']
            ]);
        } catch (NotEncodableValueException) {
            return $this->json(['error' => "Il semble y avoir un problème !"], Response::HTTP_BAD_REQUEST);
        }

        $errors = $validator->validate($userSerialize);

        if (count($errors) > 0) {

            foreach ($errors as $error) {
                $dataErrors[$error->getPropertyPath()][] = $error->getMessage();
            }

            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }  
        
        $user = new User;
        $avatarId = $data['avatar'];
        $avatar = $manager->getRepository(Avatar::class)->find($avatarId);
        $cityId = $data['city'];
        $city = $manager->getRepository(City::class)->find($cityId);
        
        
        $user->setEmail($data['email']);
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($passwordHasher->hashPassword($user, $data['password']));
        $user->setAlias($data['alias']);
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setAvatar($avatar);
        $user->setAddress($data['address']);
        $user->setCity($city);
    

        $manager->persist($user);
        $manager->flush();

        return $this->json(['message' => 'Merci de vous être inscrit !'], Response::HTTP_OK);
    }



}
