<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home() {

        return $this->render('front/home.html.twig');
    }

    /**
     * @Route("/notrehistoire", name="story")
     */
    public function story() {
        return $this->render('front/story.html.twig');
    }
}