<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }


    // Fonction permettant de rechercher selon des critères précis.
    // La variable $term est le résultat de la recherche de l'utilisateur (dans l'ArticleController)
    public function searchByTerm($term)
    {
        // Objet qui permet de créer des requêtes SQL afin de trouver des infos en BDD.
        // On choisi un alias ('a' ou 'article', ce qui nous convient)
        $queryBuilder = $this->createQueryBuilder('article');

        // Création de la requête en BDD :
        // On récupère l'alias mentionné plus haut 'article'
        $query = $queryBuilder

            // L’alias "article" (c'est à nous de choisir le nom de l'alias) est utilisé
            // pour récupérer tous les attributs de l’entité (équivalent à SELECT *)
            ->select('article')

            // Faire les jointures : cela permet étendre la recherche aux entity visées
            ->leftJoin('article.category', 'category')
            ->leftJoin('article.tag', 'tag')

            // On doit passer des paramètres de requête ici :
            ->where('article.description LIKE :term')
            ->orWhere('article.title LIKE :term')
            ->orWhere('category.title LIKE :term')
            ->orWhere('tag.name LIKE :term')

            // Permet de filtrer la requête de l'utilisateur afin d'éviter les hacks
            ->setParameter('term', '%'.$term.'%')

            // Permet de transformer la réponse en SQL
            ->getQuery();

        // Permet de récupéer tous les articles concernés par cette requête
        return $query->getResult();
    }

}
