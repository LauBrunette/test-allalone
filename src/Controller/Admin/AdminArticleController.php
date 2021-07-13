<?php

namespace App\Controller\Admin;

use App\Repository\ArticleRepository;
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
    //  variable dans laquelle on veut instancier la classe $articleRepository
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
    public function insertArticle(
        EntityManagerInterface $entityManager,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository
    )
    {
        // J'utilise l'entité Article, pour créer un nouvel article en bdd
        // une instance de l'entité Article = un enregistrement d'article en bdd
        $article = new Article();

        // j'utilise les setters de l'entité Article pour renseigner les valeurs
        // des colonnes
        $article->setTitle('Titre article depuis le controleur');
        $article->setDescription('blablalbla');
        $article->setIsPublished(true);
        $article->setCreatedAt(new \DateTime('NOW'));

        // je récupère la catégorie dont l'id est 1 en bdd
        // doctrine me créé une instance de l'entité category avec les infos de la catégorie de la bdd
        $category = $categoryRepository->find(1);
        // j'associé l'instance de l'entité categorie récupérée, à l'instane de l'entité article que je suis
        // en train de créer
        $article->setCategory($category);

        $tag = $tagRepository->findOneBy(['name' => 'info']);

        if (is_null($tag)) {
            $tag = new Tag();
            $tag->setName("info");
            $tag->setColor("yellow");
        }

        $entityManager->persist($tag);

        $article->setTag($tag);

        // je prends toutes les entités créées (ici une seule) et je les "pré-sauvegarde"
        $entityManager->persist($article);

        // je récupère toutes les entités pré-sauvegardées et je les insère en BDD
        $entityManager->flush();

        return $this->redirectToRoute("admin_article_list");
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

