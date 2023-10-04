<?php

namespace App\Controller;

use App\Repository\AvatarRepository;
use App\Repository\CategoryRepository;
use App\Repository\CityRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(PostRepository $post, UserRepository $user, CategoryRepository $category, CityRepository $city, AvatarRepository $avatar): Response
    {
        $post = $post->count([]);
        $user = $user->count([]);
        $category = $category->count([]);
        $city = $city->count([]); 
        $avatar = $avatar->count([]);
        
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'numberPost' => $post,
            'numberUser' => $user,
            'numberCategory' => $category,
            'numberCity' => $city,
            'numberAvatar' => $avatar,
            
        ]);
    }
}
