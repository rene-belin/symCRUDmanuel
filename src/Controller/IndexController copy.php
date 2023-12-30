<?php
namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route("/", name: 'article_list')]
    public function home(EntityManagerInterface $entityManager): Response
    {
        $articleRepository = $entityManager->getRepository(Article::class);
        // Retrieve all the articles from the table 'article' in the database
        $articles = $articleRepository->findAll();
        return $this->render('articles/index.html.twig', [
            'articles' => $articles
        ]);
    }
    #[Route("/article/save", name: 'app_article_save')]
    public function save(EntityManagerInterface $entityManager): Response
    {
        // Create a new Article object
        $article = new Article();
        $article->setNom('Article 3');
        $article->setPrix(3500);
        // Persist the object to prepare for saving
        $entityManager->persist($article);
        // Flush the changes to save the object in the database
        $entityManager->flush();
        // Return a response to the client with the new article's ID
        return new Response('Article enregistré avec id ' . $article->getId());
    }
    #[Route("/article/new", name: "new_article", methods: ["GET", "POST"])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // create a article
        $article = new Article();
        // create form (bind)
        $form = $this->createFormBuilder($article)
            ->add('nom', TextType::class)
            ->add('prix', TextType::class)
            ->add('save', SubmitType::class, [
                'label' => 'Créer'
            ])
            // le résultat sera mis dans form
            ->getForm();
        // pour remplir l'objet à partir du form on appel la méthode handleRequest
        $form->handleRequest($request);
        // si la form est valide on fait appel à doctrine
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            // pour enregistrer
            $entityManager->persist($article);
            // pour enregistrer dans la BDD
            $entityManager->flush();
            // Make sure the 'article_list' route exists or replace it with a valid route name.
            return $this->redirectToRoute('article_list');
        }
        return $this->render('articles/new.html.twig', ['form' => $form->createView()]);
    }
    // show
    #[Route("/article/{id}", name: "article_show")]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        // Use the EntityManager to get the Article repository
        $articleRepository = $entityManager->getRepository(Article::class);
        // Find the article by its ID
        $article = $articleRepository->find($id);

        // If the article is not found, throw a 404 exception
        if (!$article) {
            throw $this->createNotFoundException('No article found for id ' . $id);
        }

        // Render the 'show' template with the article data
        return $this->render('articles/show.html.twig', [
            'article' => $article
        ]);
    }

    // Modifier un article
    #[Route("/article/edit/{id}", name: "edit_article", methods: ["GET", "POST"])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        // Use the EntityManager to get the Article repository
        $article = $entityManager->getRepository(Article::class)->find($id);

        // If the article is not found, throw a 404 exception
        if (!$article) {
            throw $this->createNotFoundException('No article found for id ' . $id);
        }

        // Create the form
        $form = $this->createFormBuilder($article)
            ->add('nom', TextType::class)
            ->add('prix', TextType::class)
            ->add('save', SubmitType::class, [
                'label' => 'Modifier'
            ])
            ->getForm();

        // Handle the request
        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Flush the changes to the database
            $entityManager->flush();

            // Redirect to the article list
            return $this->redirectToRoute('article_list');
        }

        // Render the edit template with the form
        return $this->render('articles/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    // DELETE
    #[Route("/article/delete/{id}", name: "delete_article", methods: ["DELETE"])]
    public function delete(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $article = $entityManager->getRepository(Article::class)->find($id);
        if (!$article) {
            throw $this->createNotFoundException('No article found for id ' . $id);
        }
        $entityManager->remove($article);
        $entityManager->flush();
        return $this->redirectToRoute('article_list');
    }

}