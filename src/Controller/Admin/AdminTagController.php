<?php
namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AdminTagController extends AbstractController
{
    // URL pour ajouter des tags
    /**
     * @Route("/admin/tags/insert", name="adminTagInsert")
     */
    public function insertTag(Request $request, EntityManagerInterface $entityManager,
        TagRepository $tagRepository)
    {
        // new sert à créer une nouvelle instance de la classe tag
        $tag = new Tag();

        // créé le formulaire
        $tagForm = $this->createForm(TagType::class, $tag);

        // relie le formulaire au bouton submit
        $tagForm->handleRequest($request);

        // publie le formulaire s'il est publié et validé
        if($tagForm->isSubmitted() && $tagForm->isValid()) {
            // prépare l'entité à la création
            $entityManager->persist($tag);

            // envoie les informations en bdd
            $entityManager->flush();

            // si ok, renvoie sur la page list pour voir le nouveau tag
            return $this->redirectToRoute('adminTagList');
        }

        return $this->render('admin/admin_tag_insert.html.twig', [
            'tagForm' => $tagForm->createView()
        ]);

        // setter = renseigne le titre et la couleur du tag
      //  $tag->setTitle("Erreur");
      //  $tag->setColor("orange");

        //prépare l'entité à la création
       // $entityManager->persist($tag);
        //envoie les informations en bdd
       // $entityManager->flush();

       // return $this->redirectToRoute("adminTagList");
    }

    // URL pour mettre à jour les tags
    /**
     * @Route("/admin/tags/update/{id}", name="adminTagUpdate")
     */
    public function updateTag($id, TagRepository $tagRepository, EntityManagerInterface $entityManager)
    {
        // récupère la propriété grâce à l'id
        $tag = $tagRepository->find($id);

        // met à jour le titre du tag
        $tag->setTitle("update tag");

        //prépare l'entité à la création
        $entityManager->persist($tag);

        //envoie les informations en bdd
        $entityManager->flush();

        return $this->redirectToRoute("adminTagList");
    }

    // URL pour supprimer les tags
    /**
     * @Route("/admin/tags/delete/{id}", name="adminTagDelete")
     */
    public function deleteTag($id, TagRepository $tagRepository, EntityManagerInterface $entityManager)
    {
        //récupère la propriété grâce à l'id
        $tag = $tagRepository->find($id);

        // remove = supprime/enlève le tag dont l'id à été précisé
        $entityManager->remove($tag);

        //envoie l'information en bdd
        $entityManager->flush();

        // renvoie sur la page liste
        return $this->redirectToRoute("adminTagList");
    }

    //création de l'URL pour tous les tags
    /**
     * @Route("/admin/tags", name="adminTagList")
     */
    // création de la méthode pour récupérer le fichier twig
    public function tagList(TagRepository $tagRepository)
    {
        // variable qui va chercher tous les champs pour les afficher
        $tags = $tagRepository->findAll();

        // affiche le résulat
        return $this->render('admin/admin_tag_list.html.twig', [
            'tags' => $tags
        ]);
    }

    // création de l'URL pour un seul tag
    /**
     * @Route("/admin/tags/{id}", name="adminTagShow")
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
        return $this->render('admin/admin_tag_show.html.twig', [
            'tag' => $tag
        ]);
    }
}