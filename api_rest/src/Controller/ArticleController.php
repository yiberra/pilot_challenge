<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/article')]
final class ArticleController extends AbstractController
{
    #[Route(name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): JsonResponse
    {
        return $this->json(
            $articleRepository->findAll(),
            JsonResponse::HTTP_OK
        );
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        $entityManager->persist($article);
        $entityManager->flush();

        return $this->json(
            $article,
            JsonResponse::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): JsonResponse
    {
        if (!$article) {
            return $this->json(null, JsonResponse::HTTP_NOT_FOUND);
        }
        return $this->json($article, JsonResponse::HTTP_OK);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$article) {
            return $this->json(null, JsonResponse::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        $entityManager->flush();

        return $this->json($article, JsonResponse::HTTP_OK);
    }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
