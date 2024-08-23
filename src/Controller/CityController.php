<?php

namespace App\Controller;

use App\Entity\City;
use App\Form\CityType;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/city')]
#[IsGranted('ROLE_ADMIN')]
class CityController extends AbstractController
{
    #[Route('/', name: 'app_city_index', methods: ['GET'])]
    public function index(CityRepository $cityRepository, Request $request, PaginatorInterface $paginator): Response
    {
        // Display all cities with pagination
        $pagination = $paginator->paginate(
            $cityRepository->paginationQuery(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('city/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_city_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Create a new city with form
        $city = new City();
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        // Verify if form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($city);
            $entityManager->flush();

            // Redirect to city index
            return $this->redirectToRoute('app_city_index', [], Response::HTTP_SEE_OTHER);
        }

        // Render view
        return $this->render('city/new.html.twig', [
            'city' => $city,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_city_show', methods: ['GET'])]
    public function show(City $city): Response
    {
        // Display a city
        return $this->render('city/show.html.twig', [
            'city' => $city,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_city_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, City $city, EntityManagerInterface $entityManager): Response
    {
        // Edit a city with form
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        // Verify if form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            // Redirect to city index
            return $this->redirectToRoute('app_city_index', [], Response::HTTP_SEE_OTHER);
        }

        // Render view
        return $this->render('city/edit.html.twig', [
            'city' => $city,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_city_delete', methods: ['POST'])]
    public function delete(Request $request, City $city, EntityManagerInterface $entityManager): Response
    {
        // Delete a city
        if ($this->isCsrfTokenValid('delete'.$city->getId(), $request->request->get('_token'))) {
            $entityManager->remove($city);
            $entityManager->flush();
        }

        // Redirect to city index
        return $this->redirectToRoute('app_city_index', [], Response::HTTP_SEE_OTHER);
    }
}
