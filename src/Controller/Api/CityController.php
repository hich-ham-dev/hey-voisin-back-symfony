<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CityController extends AbstractController
{
    #[Route('/api/city', name: 'app_api_city')]
    public function index(): Response
    {
        return $this->render('api/city/index.html.twig', [
            'controller_name' => 'CityController',
        ]);
    }
}
