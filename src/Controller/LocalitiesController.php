<?php

namespace App\Controller;

use App\Entity\Localities;
use App\Form\LocalitiesType;
use App\Repository\LocalitiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/localities')]
class LocalitiesController extends AbstractController
{
    #[Route('/', name: 'app_localities_index', methods: ['GET'])]
    public function index(LocalitiesRepository $localitiesRepository): Response
    {
        return $this->render('localities/index.html.twig', [
            'localities' => $localitiesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_localities_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $locality = new Localities();
        $form = $this->createForm(LocalitiesType::class, $locality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($locality);
            $entityManager->flush();

            return $this->redirectToRoute('app_localities_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('localities/new.html.twig', [
            'locality' => $locality,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_localities_show', methods: ['GET'])]
    public function show(Localities $locality): Response
    {
        return $this->render('localities/show.html.twig', [
            'locality' => $locality,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_localities_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Localities $locality, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LocalitiesType::class, $locality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_localities_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('localities/edit.html.twig', [
            'locality' => $locality,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_localities_delete', methods: ['POST'])]
    public function delete(Request $request, Localities $locality, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$locality->getId(), $request->request->get('_token'))) {
            $entityManager->remove($locality);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_localities_index', [], Response::HTTP_SEE_OTHER);
    }
}
