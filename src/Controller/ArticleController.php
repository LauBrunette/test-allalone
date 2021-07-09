<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="articleList")
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

        if (is_null($articles)) {
            throw new NotFoundHttpException();
        }

        return $this->render('article_list.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/articles/{id}", name="articleShow")
     */
    // On peut passer plusieurs paramètres, comme dans ce cas on doit récupérer l'ID
    public function articleShow($id, ArticleRepository $articleRepository)
    {
        // Un seul article en fonction de l'ID en wildcard {}
        $article = $articleRepository->find($id);

        // Si l'article n'existe pas en BDD, on envoit une erreur 404 grâce à la méthode throw
        if (is_null($article)) {
            throw new NotFoundHttpException();
        }

        return $this->render('article_show.html.twig', [
            'article' => $article
        ]);

    }

    // Créer une route qui permet de rechercher du contenu
    /**
     * @Route("/search", name="search")
     */
    public function search(ArticleRepository $articleRepository)
    {
        // Résultat de la recherche de l'utilisateur (en dur pour le moment)
        $term = 'Mammifère';

        // Méthode searchByTerm : récupère le contenu de la recherche, donc le $term
        $articles = $articleRepository->searchByTerm($term);

        // On affiche mles résultats dans un fichier twig
        return $this->render('article_search.html.twig', [
            'articles' => $articles
        ]);
    }


}

