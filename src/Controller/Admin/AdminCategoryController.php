<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{

    /**
     * @Route("/admin/categories", name="admin_category_list")
     */
    public function categoryList(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        if (is_null($categories)) {
            throw new NotFoundHttpException();
        }

        return $this->render('admin/admin_category_list.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("admin/categories/{id}", name="admin_category_show")
     */
    public function categoryShow($id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        if (is_null($category)) {
            throw new NotFoundHttpException();
        }

        return $this->render('admin/admin_category_show.html.twig', [
        'category'=> $category
        ]);
    }

    /**
     * @Route("admin/category/insert", name="admin_category_insert")
     */
    public function categoryInsert(EntityManagerInterface $entityManager)
    {
        $category = new Category();

        $category->setTitle('NOUVEAU TITRE CATEGORIEEEE');
        $category->setDescription('coucou la nouvelle description');
        $category->setCreatedAt(new \DateTime('NOW'));
        $category->setIsPublished(true);

        $entityManager->persist($category);
        $entityManager->flush();

        return $this->redirectToRoute('admin_category_list');

    }

    /**
     * @Route("/admin/category/delete/{id}", name="admin_category_delete")
     */
    public function deleteCategory($id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {
        $category = $categoryRepository->find($id);

        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute("admin_category_list");
    }

    /**
     * @Route("/admin/category/update/{id}", name="admin_category_update")
     */
    public function updateCategory($id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {
        $category = $categoryRepository->find($id);

        $category->setTitle("SUPER NOUVEAU TITRE");

        $entityManager->persist($category);
        $entityManager->flush();

        return $this->redirectToRoute("admin_category_list");
    }


}