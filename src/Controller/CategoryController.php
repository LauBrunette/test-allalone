<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private $categories = [
        1 => [
            "title" => "Politique",
            "content" => "la politique en son sens plus large, celui de civilité ou Politikos, désigne ce qui est relatif à l'organisation ou autogestion d'une cité ou d'un État et à l'exercice du pouvoir dans une société organisée ;
en général, la politique d'une communauté, d'une société, d'un groupe social, au sens de Politeia, se conforme à une constitution rédigée par ses fondateurs qui définit sa structure et son fonctionnement (méthodique, théorique et pratique). La politique porte sur les actions, l’équilibre, le développement interne ou externe de cette société, ses rapports internes et ses rapports à d'autres ensembles. La politique est donc principalement ce qui a trait au collectif, à une somme d'individualités ou de multiplicités. C'est dans cette optique que les études politiques ou la science politique s'élargissent à tous les domaines d'une société (économie, droit, sociologie...) ;
dans une acception plus restrictive, la politique au sens de Politikè ou d'art politique, se réfère à la pratique du pouvoir, soit donc aux luttes de pouvoir et de représentativité entre des hommes et femmes de pouvoir, et aux différents partis politiques auxquels ils peuvent appartenir, tout comme à la gestion de ce même pouvoir ;
la politique est le plus souvent assortie d'une épithète qui détermine sa définition : on parle de stratégie politique1 par exemple pour expliquer comment elle se situe dans une perception combinatoire et planifiée de nature à lui faire atteindre ses objectifs.",
            "id" => 1,
            "published" => true,
        ],
        2 => [
            "title" => "Economie",
            "content" => "Les meilleurs tuyaux pour avoir DU FRIC",
            "id" => 2,
            "published" => true
        ],
        3 => [
            "title" => "Sécurité",
            "content" => "Attention les étrangers sont très méchants",
            "id" => 3,
            "published" => true
        ],
        4 => [
            "title" => "Ecologie",
            "content" => "Hummer <3",
            "id" => 4,
            "published" => true
        ]
    ];

    /**
     * @Route("/categories", name="categoriesList")
     */
    public function categoriesList()
    {
        return $this->render('category_list.html.twig', [
        'categories' => $this->categories
        ]);
    }

    /**
     * @Route("category/{id}", name="categoryShow")
     */
    public function categoryShow($id)
    {
        return $this->render('category_show.html.twig', [
        'category'=> $this->categories[$id]
        ]);
    }



}