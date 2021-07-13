<?php


namespace App\Controller\Front;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class FrontArticleController extends AbstractController
{

    // Créer une route qui permet de rechercher du contenu
    // On instancie les classes ArticleRepository et Request afin de se servir de leur fonctionnalités
    /**
     * @Route("/search", name="search")
     */
    public function search(ArticleRepository $articleRepository, Request $request)
    {
        $term = $request->query->get('q');

        $articles = $articleRepository->searchByTerm($term);

        return $this->render('front/article_search.html.twig', [
            'articles' => $articles,
            'term' => $term
        ]);
    }

    /**
     * @Route("/articles", name="front_article_list")
     */
    public function articleList(ArticleRepository $articleRepository)
    {

        $articles = $articleRepository->findAll();

        return $this->render('front/article_list.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/articles/{id}", name="front_article_show")
     */
    public function articleShow($id, ArticleRepository $articleRepository)
    {

        $article = $articleRepository->find($id);

        return $this->render('front/article_show.html.twig', [
            'article' => $article
        ]);
    }
}