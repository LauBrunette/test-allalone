<?php

namespace App\Controller\Admin;

use App\Repository\ArticleRepository;
use App\Form\ArticleType;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use App\Entity\Article;
use App\Entity\Tag;
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
    public function insertArticle()
    {
        $article = new Article();
        $articleForm = $this->createForm(ArticleType::class, $article);

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
    public function updateArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $article = $articleRepository->find($id);

        $article->setTitle("SUPER NOUVEAU TITRE");

        $entityManager->persist($article);
        $entityManager->flush();

        return $this->redirectToRoute("admin_article_list");
    }

}

