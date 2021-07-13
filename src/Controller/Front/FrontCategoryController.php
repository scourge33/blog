<?php
namespace App\Controller\Front;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class FrontCategoryController extends AbstractController
    {
    // création de l'URL pour toutes les catégories

    /**
     * @Route("/front/categories", name="frontListCategories")
     */

    // création de la méthode pour récupérer le fichier twig
        public function listCategories(CategoryRepository $categoryRepository)
        {
            $categories = $categoryRepository -> findAll();

            return $this->render('front/front_categories.html.twig', [
                'categories' => $categories
            ]);
        }

    /**
     * @Route("/front/categories/{id}", name="frontCategoryShow")
     */
      // création de la méthode pour afficher l'url d'une seule catégorie
        public function categoryShow($id, CategoryRepository $categoryRepository)
        {
            $categorie = $categoryRepository->find($id);

            // affiche un message d'erreur si une catégorie n'existe pas
            if (is_null($categorie)) {
                throw new NotFoundHttpException();
            }

            return $this -> render('front/front_category.html.twig', [
                'categorie' => $categorie
            ]);
        }
    }