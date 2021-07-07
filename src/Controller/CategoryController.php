<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    /**
     * @Route("/categories", name="categoryList")
     */
    public function categoriyList(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category_list.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("categories/{id}", name="categoryShow")
     */
    public function categoryShow($id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        return $this->render('category_show.html.twig', [
        'category'=> $category
        ]);
    }



}