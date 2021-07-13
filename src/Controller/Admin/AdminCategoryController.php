<?php
namespace App\Controller\Admin;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    // URL pour ajouter des catégories
    /**
     * @Route("/admin/categories/insert", name="adminCategoryInsert")
     */
    public function insertCategory(
        EntityManagerInterface $entityManager,
        CategoryRepository $categoryRepository
    )
    {
        // new sert à créer une nouvelle instance de la classe tag
        $category = new Category();

        // setter = renseigne le titre, le contenu et si la catégorie est publiée
        $category->setTitle("Titre de la catégorie");
        $category->setContent("Contenu de la catégorie");
        $category->setPublished(true);

        // garde l'événement en attente
        $category = $categoryRepository->find(5);

        // envoie les informations en bdd
        $entityManager->flush();

        return $this->redirectToRoute("adminListCategories");
    }

    // création de l'URL pour mettre à jour les catégories
    /**
     * @Route("/admin/categories/update{id}", name="adminCategoryUpdate")
     */
    public function updateCategory($id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {
        // récupère la propriété grâce à l'id
        $category = $categoryRepository->find($id);

        // met à jour le titre de la catégorie
        $category->setTitle("update titre");

        // prépare l'entité à la création
        $entityManager->persist($category);

        // envoie les informations en bdd
        $entityManager->flush();

        return $this->redirectToRoute("adminListCategories");
    }

    // URL pour supprimer une catégorie grâce à son id
    /**
     * @Route("admin/categories/delete{id}", name="adminCategoryDelete")
     */
    public function deleteCategory($id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {
        //récupère la propriété grâce à l'id
        $category = $categoryRepository->find{$id};

        // remove = supprime/enlève l'article dont l'id a été précisé
        $entityManager->remove($category);

        // envoie l'information en bdd
        $entityManager->flush();

        // renvoie sur la page liste
        return $this->redirectToRoute("adminListCategories");
    }

    // création de l'URL pour toutes les catégories
    /**
     * @Route("/admin/categories", name="adminListCategories")
     */
    // création de la méthode pour récupérer le fichier twig
        public function listCategories(CategoryRepository $categoryRepository)
        {
            $categories = $categoryRepository -> findAll();

            return $this->render('admin/admin_categories.html.twig', [
                'categories' => $categories
            ]);
        }

    /**
     * @Route("/admin/categories/{id}", name="adminCategoryShow")
     */
      // création de la méthode pour afficher l'url d'une seule catégorie
        public function categoryShow($id, CategoryRepository $categoryRepository)
        {
            $categorie = $categoryRepository->find($id);

            // affiche un message d'erreur si une catégorie n'existe pas
            if (is_null($categorie)) {
                throw new NotFoundHttpException();
            }

            return $this -> render('admin/admin_category.html.twig', [
                'categorie' => $categorie
            ]);
        }
}