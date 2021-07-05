<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{

    // création de l'URL pour toutes les catégories

    /*
     * @Route("/categories", name="category)
     */

    // création de la méthode
    public function listCategories()
    {
        $categories = [
            1 => [
                "title" => "Politique",
                "content" => "Tous les articles liés à Jean Lassalle",
                "id" => 1,
                "published" => true,
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
    }