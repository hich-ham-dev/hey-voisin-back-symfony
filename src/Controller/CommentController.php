<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/comment')]
#[IsGranted('ROLE_ADMIN')]
class CommentController extends AbstractController
{
    #[Route('/', name: 'app_comment_index', methods: ['GET'])]
    public function index(CommentRepository $commentRepository, Request $request, PaginatorInterface $paginator): Response
    {
        // Display all comments with pagination
        $pagination = $paginator->paginate(
            $commentRepository->paginationQuery(),
            $request->query->getInt('page', 1),
            10
        );

        // Render view
        return $this->render('comment/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_comment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Create a new comment with form
        $comment = new Comment();
        $comment->setPublishedAt(new \DateTimeImmutable());
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        // Verify if form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();

            // Redirect to comment index
            return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        // Render view
        return $this->render('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_comment_show', methods: ['GET'])]
    public function show(Comment $comment): Response
    {
        // Display a comment
        return $this->render('comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_comment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comment $comment, EntityManagerInterface $entityManager): Response
    {
        // Edit a comment with form
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        // Verify if form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->flush();

            // Redirect to comment index
            return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        // Render view
        return $this->render('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_comment_delete', methods: ['POST'])]
    public function delete(Request $request, Comment $comment, EntityManagerInterface $entityManager): Response
    {
        // Delete a comment
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        // Redirect to comment index
        return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
    }
}
