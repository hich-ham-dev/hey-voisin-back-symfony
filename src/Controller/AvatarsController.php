<?php

namespace App\Controller;

use App\Entity\Avatars;
use App\Form\AvatarsType;
use App\Repository\AvatarsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/avatars')]
class AvatarsController extends AbstractController
{
    #[Route('/', name: 'app_avatars_index', methods: ['GET'])]
    public function index(AvatarsRepository $avatarsRepository): Response
    {
        return $this->render('avatars/index.html.twig', [
            'avatars' => $avatarsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_avatars_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $avatar = new Avatars();
        $form = $this->createForm(AvatarsType::class, $avatar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($avatar);
            $entityManager->flush();

            return $this->redirectToRoute('app_avatars_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avatars/new.html.twig', [
            'avatar' => $avatar,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avatars_show', methods: ['GET'])]
    public function show(Avatars $avatar): Response
    {
        return $this->render('avatars/show.html.twig', [
            'avatar' => $avatar,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_avatars_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Avatars $avatar, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AvatarsType::class, $avatar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_avatars_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avatars/edit.html.twig', [
            'avatar' => $avatar,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avatars_delete', methods: ['POST'])]
    public function delete(Request $request, Avatars $avatar, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$avatar->getId(), $request->request->get('_token'))) {
            $entityManager->remove($avatar);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_avatars_index', [], Response::HTTP_SEE_OTHER);
    }
}
