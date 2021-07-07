<?php
namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
    {
    // création de l'URL pour toutes les catégories

    /**
     * @Route("/categories", name="listCategories")
     */

    // création de la méthode pour récupérer le fichier twig
        public function listCategories(CategoryRepository $categoryRepository)
        {
            $categories = $categoryRepository -> findAll();

            return $this->render('categories.html.twig', [
                'categories' => $categories
            ]);
        }

    /**
     * @Route("/categories/{id}", name="categoryShow")
     */
      // création de la méthode pour afficher l'url d'une catégorie
        public function categoryShow($id, CategoryRepository $categoryRepository)
        {
            $categorie = $categoryRepository -> find($id);

            return $this -> render('category.html.twig', [
                'categorie' => $categorie
            ]);
        }
    }