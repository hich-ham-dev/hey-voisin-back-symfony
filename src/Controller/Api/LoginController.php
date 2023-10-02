<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/api/login', name: 'app_api_login')]
    public function index(): Response
    {
        return $this->render('api/login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }
}
