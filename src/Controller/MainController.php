<?php

namespace App\Controller;

use App\Repository\AvatarRepository;
use App\Repository\CategoryRepository;
use App\Repository\CityRepository;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(PostRepository $postRepository, UserRepository $userRepository, CategoryRepository $categoryRepository, CityRepository $cityRepository, AvatarRepository $avatarRepository, CommentRepository $commentRepository): Response
    {
        // Count all the posts, users, categories, cities, avatars and comments
        $post = $postRepository->count([]);
        $user = $userRepository->count([]);
        $category = $categoryRepository->count([]);
        $city = $cityRepository->count([]); 
        $avatar = $avatarRepository->count([]);
        $comment = $commentRepository->count([]);
        
        // Display counters of posts, users, categories, cities, avatars and comments
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'numberPost' => $post,
            'numberUser' => $user,
            'numberCategory' => $category,
            'numberCity' => $city,
            'numberAvatar' => $avatar,
            'numberComment' => $comment,
        ]);
    }
}
