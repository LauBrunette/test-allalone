<?php


namespace App\Controller;


use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class PageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home() {
        return $this->render('category_list.html.twig');
    }
}