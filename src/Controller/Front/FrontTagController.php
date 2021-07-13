<?php


namespace App\Controller\Front;

use App\Entity\Tag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontTagController extends AbstractController
{
    /**
     * @Route("/tags", name="tagList")
     */
    public function tagList(TagRepository $tagRepository)
    {
        $tags = $tagRepository->findAll();

        if (is_null($tags)) {
            throw new NotFoundHttpException();
        }

        return $this->render('front/tag_list.html.twig', [
            'tags' => $tags
        ]);
    }

    /**
     * @Route("/tags/{id}", name="tagShow")
     */
    public function tagShow($id, TagRepository $tagRepository)
    {
        $tag = $tagRepository->find($id);

        // Si le tag n'existe pas en BDD, on envoit une erreur 404 grâce à la méthode "throw"
        if (is_null($tag)) {
            throw new NotFoundHttpException();
        }

        return $this->render('front/tag_show.html.twig', [
            'tag' => $tag
        ]);

    }

}