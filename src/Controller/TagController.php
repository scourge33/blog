<?php
namespace App\Controller;

use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    //création de l'URL pour tous les tags
    /**
     * @Route("/tags", name="tagList")
     */
    // création de la méthode pour récupérer le fichier twig
    public function tagList(TagRepository $tagRepository)
    {
        // variable qui va chercher tous les champs pour les afficher
        $tags = $tagRepository->findAll();

        // affiche le résulat
        return $this->render('tag_list.html.twig', [
            'tags' => $tags
        ]);
    }

    // création de l'URL pour un seul tag
    /**
     * @Route("/tags/{id}", name="tagShow")
     */
    public function tagShow($id, TagRepository $tagRepository)
    {
        // variable qui va chercher le champ id
        $tag = $tagRepository->find($id);

        // affiche un message d'erreur si un tag n'existe pas
        if (is_null($tag)) {
            throw new NotFoundHttpException();
        }

        // affiche le résulat
        return $this->render('tag_show.html.twig', [
            'tag' => $tag
        ]);
    }
}