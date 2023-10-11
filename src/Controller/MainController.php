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
    public function index(PostRepository $post, UserRepository $user, CategoryRepository $category, CityRepository $city, AvatarRepository $avatar, CommentRepository $comment): Response
    {
        // Count all the posts, users, categories, cities, avatars and comments
        $post = $post->count([]);
        $user = $user->count([]);
        $category = $category->count([]);
        $city = $city->count([]); 
        $avatar = $avatar->count([]);
        $comment = $comment->count([]);
        
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
