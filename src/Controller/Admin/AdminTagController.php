<?php


namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTagController extends AbstractController
{
    /**
     * @Route("/admin/tags", name="admin_tag_list")
     */
    public function tagList(TagRepository $tagRepository)
    {
        $tags = $tagRepository->findAll();

        if (is_null($tags)) {
            throw new NotFoundHttpException();
        }

        return $this->render('admin/admin_tag_list.html.twig', [
            'tags' => $tags
        ]);
    }

    /**
     * @Route("/admin/tags/{id}", name="admin_tag_show")
     */
    public function tagShow($id, TagRepository $tagRepository)
    {
        $tag = $tagRepository->find($id);

        // Si le tag n'existe pas en BDD, on envoit une erreur 404 grâce à la méthode "throw"
        if (is_null($tag)) {
            throw new NotFoundHttpException();
        }

        return $this->render('admin/admin_tag_show.html.twig', [
            'tag' => $tag
        ]);

    }

    /**
     * @Route("/admin/tag/update/{id}", name="admin_tag_update")
     */
    public function tagUpdate($id, TagRepository $tagRepository, EntityManagerInterface $entityManager)
    {
       $tag = $tagRepository->find($id);

       $tag->setName("SUPER NOUVEAU TAG");

       $entityManager->persist($tag);
       $entityManager->flush();

       return $this->redirectToRoute("admin_tag_list");
    }

    /**
     * @Route("/admin/tag/delete/{id}", name="admin_tag_delete")
     */
    public function tagDelete($id, TagRepository $tagRepository, EntityManagerInterface $entityManager)
    {
        $tag = $tagRepository->find($id);

        $entityManager->remove($tag);
        $entityManager->flush();

        return $this->redirectToRoute("admin_tag_list");
    }

    /**
     * @Route("/admin/tag/insert", name="admin_tag_insert")
     */
      public function tagInsert(EntityManagerInterface $entityManager, ArticleRepository $articleRepository)
      {
            $tag = new Tag();

            $tag->setName('Titre depuis le controller');
            $tag->setColor('yellow');

            $entityManager->persist($tag);
            $entityManager->flush();

            return $this->redirectToRoute("admin_tag_list");

      }

}









