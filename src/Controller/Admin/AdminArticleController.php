<?php

namespace App\Controller\Admin;

use App\Repository\ArticleRepository;
use App\Form\ArticleType;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use App\Entity\Article;
use App\Entity\Tag;
use ContainerE94sIKn\get_Maker_AutoCommand_MakeEntity_LazyService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class AdminArticleController extends AbstractController
{
    /**
     * @Route("/admin/articles", name="admin_article_list")
     */

    // Sert à faire une requête SQL SELECT en BDD, sur la table Article
    // ArticleRepository : classe qui nous permet de faire ces requêtes
    // On doit donc instancier cette classe (grâce à l'autowire)
    // On place la classe ArticleRepository en argument du controller, suivi de la
    // variable dans laquelle on veut instancier la classe $articleRepository
    public function articleList(ArticleRepository $articleRepository)
    {

        // Ceci est une méthode de la classe articleRepository (on le sait grâce à ->)
        // la méthode findAll nous permet d'aller récupérer touts les éléments de la table

        $articles = $articleRepository->findAll();

        return $this->render('admin/admin_article_list.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/admin/articles/insert", name="admin_article_insert")
     */
    public function insertArticle(Request $request, EntityManagerInterface $entityManager)
    {
        $article = new Article();

        // Permet de générer le formulaire en utilisant un gabarit standard, et une instance de l'entité Article
        $articleForm = $this->createForm(ArticleType::class, $article);

        // Permet de lier le formulaire aux données envoyées en POST
        $articleForm->handleRequest($request);

        // Si le formulaire a été envoyé et que les champs sont tous remplis et valides (du bon type)
        if ($articleForm->isSubmitted() && $articleForm->isValid() ) {
            // On pré-sauvegarde les données
            $entityManager->persist($article);
            // ...et on les envoie en BDD
            $entityManager->flush();

            return $this->redirectToRoute('admin_article_list');
        }

        return $this->render('admin/admin_insert_article.html.twig', [
            'articleForm' => $articleForm->createView()
        ]);
    }

    /**
     * @Route("/admin/articles/delete/{id}", name="admin_article_delete")
     */
    public function deleteArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $article = $articleRepository->find($id);

        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute("admin_article_list");
    }

    /**
     * @Route("/admin/articles/update/{id}", name="admin_article_update")
     */
    public function updateArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager, Request $request)
    {
        // La différence avec l'insert, c'est qu'on va récupérer l'ID de l'article qu'on veut modifier
        // On ne crée donc pas de nouvel article ($article = new Article() ) --> sinon la méthode est identique
        // Les données de l'article sont déjà pré-chargées (Symfony s'en occupe)
        $article = $articleRepository->find($id);

        // Permet de générer le formulaire en utilisant un gabarit standard, et une instance de l'entité Article
        $articleForm = $this->createForm(ArticleType::class, $article);

        // Permet de lier le formulaire aux données envoyées en POST
        $articleForm->handleRequest($request);

        // Si le formulaire a été envoyé et que les champs sont tous remplis et valides (du bon type)
        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            // On pré-sauvegarde les données
            $entityManager->persist($article);
            // ...et on les envoie en BDD
            $entityManager->flush();

            return $this->redirectToRoute('admin_article_list');
        }

        return $this->render('admin/admin_insert_article.html.twig', [
            'articleForm' => $articleForm->createView()
        ]);
    }

    /**
     * @Route("/admin/articles/{id}", name="admin_article_show")
     */
    public function showArticle($id, ArticleRepository $articleRepository)
    {

        $article = $articleRepository->find($id);

        return $this->render('admin/admin_article_show.html.twig', [
            'article' => $article
        ]);
    }
}

