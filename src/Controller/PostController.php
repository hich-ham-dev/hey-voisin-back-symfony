<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/post')]
class PostController extends AbstractController
{
    #[Route('/', name: 'app_post_index', methods: ['GET'])]
    #[IsGranted('ROLE_MODERATOR')]
    public function index(PostRepository $post, Request $request, PaginatorInterface $paginator): Response
    {
        // Display all posts with pagination
        $pagination = $paginator->paginate(
            $post->paginationQuery(),
            $request->query->getInt('page', 1),
            10
        );

        // Render view
        return $this->render('post/index.html.twig', [
            'pagination' => $pagination,            
        ]);
    }

    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {   
        // Create a new post with form
        $post = new Post();
        $post->setPublishedAt(new \DateTimeImmutable());
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        // Verify if form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($post);
            $entityManager->flush();

            // Flash message
            $this->addFlash(
                'success', 
                'Votre annonce a bien été créée'
            );

            // Redirect to post index
            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        // Render view
        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_show', methods: ['GET'])]
    #[IsGranted('ROLE_MODERATOR')]
    public function show(Post $post): Response
    {
        // Display a post
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_post_edit', methods: ['GET','POST','PUT'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {   
        // Edit a post with form
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        // Verify if form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->flush();

            // Flash message
            $this->addFlash(
                'warning', 
                'Votre annonce a bien été modifiée'
            );

            // Redirect to post index
            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        // Render view
        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_delete', methods: ['POST'])]
    #[IsGranted('ROLE_MODERATOR')]
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        // Delete a post
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();

            // Flash message
            $this->addFlash(
                'danger', 
                'Votre annonce a bien été supprimée'
            );
        }

        // Redirect to post index
        return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/search', name: 'app_post_search', methods: ['GET'])]
    #[IsGranted('ROLE_MODERATOR')]
    public function search(Request $request, PostRepository $postRepository): Response
    {
        $query = $request->query->get('q', '');

        $posts = $postRepository->searchByQuery($query);

        return $this->render('post/_post_list.html.twig', [
            'posts' => $posts,
        ]);
    }
}
