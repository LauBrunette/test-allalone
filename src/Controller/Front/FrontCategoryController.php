<?php

namespace App\Controller\Front;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class FrontCategoryController extends AbstractController
{

    /**
     * @Route("/categories", name="front_category_list")
     */
    public function categoriyList(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        if (is_null($categories)) {
            throw new NotFoundHttpException();
        }

        return $this->render('front/category_list.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/categories/{id}", name="front_category_show")
     */
    public function categoryShow($id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        if (is_null($category)) {
            throw new NotFoundHttpException();
        }

        return $this->render('front/category_show.html.twig', [
        'category'=> $category
        ]);
    }



}