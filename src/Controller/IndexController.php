<?php
// src/Controller/IndexController.php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route("/", name: "article_list")]
    public function home(EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager->getRepository(Article::class)->findAll();
        return $this->render('articles/index.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route("/article/{id}", name: "article_show", requirements: ["id" => "\d+"])]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        $article = $entityManager->getRepository(Article::class)->find($id);
        if (!$article) {
            throw $this->createNotFoundException('No article found for id ' . $id);
        }
        return $this->render('articles/show.html.twig', ['article' => $article]);
    }

    #[Route("/article/new", name: "new_article", methods: ["GET", "POST"])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('article_list');
        }
        return $this->render('articles/new.html.twig', ['form' => $form->createView()]);
    }

    #[Route("/article/edit/{id}", name: "edit_article", methods: ["GET", "POST"])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $article = $entityManager->getRepository(Article::class)->find($id);
        if (!$article) {
            throw $this->createNotFoundException('No article found for id ' . $id);
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('article_list');
        }
        return $this->render('articles/edit.html.twig', ['form' => $form->createView()]);
    }

    #[Route("/article/delete/{id}", name: "delete_article", methods: ["POST"])]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id, SessionInterface $session): Response
    {
        $article = $entityManager->getRepository(Article::class)->find($id);
        if (!$article) {
            throw $this->createNotFoundException('No article found for id ' . $id);
        }

        $submittedToken = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $submittedToken)) {
            $entityManager->remove($article);
            $entityManager->flush();
            $session->getFlashBag()->add('success', 'Article deleted successfully!');
        } else {
            $session->getFlashBag()->add('error', 'Invalid CSRF token.');
        }
        return $this->redirectToRoute('article_list');
    }

    #[Route('/category/newCat', name: 'new_category', methods: ['GET', 'POST'])]
    public function newCategory(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            // Redirect to a route or add a flash message if needed
        }

        return $this->render('articles/newCategory.html.twig', [
            'form' => $form->createView(),
        ]);
    }



}
