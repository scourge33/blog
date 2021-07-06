<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
    {
        // création du tableau (propriété = attribut/variable)
        private $categories = [
            1 => [
                "title" => "Politique",
                "content" => "Tous les articles liés à Jean Lassalle",
                "id" => 1,
                "published" => true

            ],
            2 => [
                "title" => "Economie",
                "content" => "Les meilleurs tuyaux pour avoir DU FRIC",
                "id" => 2,
                "published" => true

            ],
            3 => [
                "title" => "Securité",
                "content" => "Attention les étrangers sont très méchants",
                "id" => 3,
                "published" => false

            ],
            4 => [
                "title" => "Ecologie",
                "content" => "Hummer <3",
                "id" => 4,
                "published" => true

            ]
        ];
    // création de l'URL pour toutes les catégories

    /**
     * @Route("/categories", name="listCategories")
     */
    // création de la méthode pour récupérer le fichier twig
        public function listCategories()
        {
            return $this->render('categories.html.twig', [
                'categories' => $this->categories]
            );
        }
      // création de la méthode pour afficher l'url d'une catégorie
        public function categoryShow($id) {
            return $this->render(view )
        }
    }