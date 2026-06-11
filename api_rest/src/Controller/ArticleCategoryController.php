<?php

namespace App\Controller;

use App\Entity\ArticleCategory;
use App\Form\ArticleCategoryType;
use App\Repository\ArticleCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/article/category')]
final class ArticleCategoryController extends AbstractController
{
    #[Route(name: 'app_article_category_index', methods: ['GET'])]
    public function index(ArticleCategoryRepository $articleCategoryRepository): JsonResponse
    {
        return $this->json(
            $articleCategoryRepository->findAll(),
            JsonResponse::HTTP_OK
        );
    }

    #[Route('/new', name: 'app_article_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $articleCategory = new ArticleCategory();
        $form = $this->createForm(ArticleCategoryType::class, $articleCategory);
        $form->handleRequest($request);

        $entityManager->persist($articleCategory);
        $entityManager->flush();

        return $this->json(
            $articleCategory,
            JsonResponse::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'app_article_category_show', methods: ['GET'])]
    public function show(ArticleCategory $articleCategory): JsonResponse
    {
        if (!$articleCategory) {
            return $this->json(null, JsonResponse::HTTP_NOT_FOUND);
        }
        return $this->json($articleCategory, JsonResponse::HTTP_OK);
    }

    #[Route('/{id}/edit', name: 'app_article_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ArticleCategory $articleCategory, EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$articleCategory) {
            return $this->json(null, JsonResponse::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(ArticleCategoryType::class, $articleCategory);
        $form->handleRequest($request);

        $entityManager->flush();

        return $this->json($articleCategory, JsonResponse::HTTP_OK);
    }

    #[Route('/{id}', name: 'app_article_category_delete', methods: ['POST'])]
    public function delete(Request $request, ArticleCategory $articleCategory, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($articleCategory);
        $entityManager->flush();

        return $this->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
