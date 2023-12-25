<?php

namespace App\Controller;

use App\Entity\Avatar;
use App\Form\AvatarType;
use App\Repository\AvatarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/avatar')]
#[IsGranted('ROLE_ADMIN')]
class AvatarController extends AbstractController
{
    #[Route('/', name: 'app_avatar_index', methods: ['GET'])]
    public function index(AvatarRepository $avatarRepository, Request $request, PaginatorInterface $paginator): Response
    {
        // Get all avatars with pagination
        $pagination = $paginator->paginate(
            $avatarRepository->paginationQuery(),
            $request->query->getInt('page', 1),
            10
        );

        // Render view
        return $this->render('avatar/index2.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_avatar_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Create new avatar with form
        $avatar = new Avatar();
        $form = $this->createForm(AvatarType::class, $avatar);
        $form->handleRequest($request);

        // Verify form
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($avatar);
            $entityManager->flush();

            return $this->redirectToRoute('app_avatar_index', [], Response::HTTP_SEE_OTHER);
        }

        // Render view
        return $this->render('avatar/new.html.twig', [
            'avatar' => $avatar,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avatar_show', methods: ['GET'])]
    public function show(Avatar $avatar): Response
    {
        // Render view
        return $this->render('avatar/show.html.twig', [
            'avatar' => $avatar,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_avatar_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Avatar $avatar, EntityManagerInterface $entityManager): Response
    {   
        // Edit avatar with form
        $form = $this->createForm(AvatarType::class, $avatar);
        $form->handleRequest($request);

        // Verify form
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_avatar_index', [], Response::HTTP_SEE_OTHER);
        }

        // Render view
        return $this->render('avatar/edit.html.twig', [
            'avatar' => $avatar,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avatar_delete', methods: ['POST'])]
    public function delete(Request $request, Avatar $avatar, EntityManagerInterface $entityManager): Response
    {
        // Delete avatar 
        if ($this->isCsrfTokenValid('delete'.$avatar->getId(), $request->request->get('_token'))) {
            $entityManager->remove($avatar);
            $entityManager->flush();
        }

        // Redirect to avatar index
        return $this->redirectToRoute('app_avatar_index', [], Response::HTTP_SEE_OTHER);
    }
}
