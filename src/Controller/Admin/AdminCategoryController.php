<?php
namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    // URL pour ajouter des catégories
    /**
     * @Route("/admin/categories/insert", name="adminCategoryInsert")
     */
    public function insertCategory(Request $request, EntityManagerInterface $entityManager,
        CategoryRepository $categoryRepository)
    {
        // new sert à créer une nouvelle instance de la classe category
        $category = new Category();

        // créé le formulaire
        $categoryForm = $this->createForm(CategoryType::class, $category);

        // relie le formulaire au bouton submit
        $categoryForm->handleRequest($request);

        // Publie le formulaire s'il est publié et validé
        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            // prépare l'entité à la création
            $entityManager->persist($category);

            // envoie les informations en bdd
            $entityManager->flush();

            // message d'info pour indiquer que la catégorie a été créé
            $this->addFlash(
                'success',
                'La catégorie '. $category->getTitle().' a bien été créée !'
            );

            // si ok, renvoie sur la page list pour voir la nouvelle catégorie
            return $this->redirectToRoute('adminListCategories');
        }

        return $this->render('admin/admin_category_insert.html.twig', [
            'categoryForm' => $categoryForm->createView()
        ]);

    }

        // setter = renseigne le titre, le contenu et si la catégorie est publiée
    //    $category->setTitle("Titre de la catégorie");
     //   $category->setContent("Contenu de la catégorie");
     //   $category->setPublished(true);

        // garde l'événement en attente
     //   $category = $categoryRepository->find(5);

       // envoie les informations en bdd
     //   $entityManager->flush();

     //   return $this->redirectToRoute("adminListCategories");


    // création de l'URL pour mettre à jour les catégories
    /**
     * @Route("/admin/categories/update{id}", name="adminCategoryUpdate")
     */
    public function updateCategory($id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager, Request $request)
    {
        // récupère la propriété grâce à l'id
        $category = $categoryRepository->find($id);

        // propose le formulaire pour modifier la catégorie
        $categoryForm = $this->createForm(CategoryType::class, $category);

        // lie le formulaire aux modifications
        $categoryForm->handleRequest($request);

        // Met à jour si les conditions sont remplies correctement
        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            // prépare l'entité à la création
            $entityManager->persist($category);
            // envoie les informations en bdd
            $entityManager->flush();
            // message d'info pour indiquer que la catégorie a été maj
            $this->addFlash(
                'success',
                'La catégorie '. $category->getTitle().' a bien été mis à jour !'
            );

            return $this->redirectToRoute('adminListCategories');
        }

        //renvoi du formulaire sur une page vue si le formulaire n est pas validé
        return $this->render('Admin/admin_category_insert.html.twig',['categoryForm'=> $categoryForm ->createView()] );
    }

    // URL pour supprimer une catégorie grâce à son id
    /**
     * @Route("admin/categories/delete/{id}", name="adminCategoryDelete")
     */
    public function deleteCategory($id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {
        //récupère la propriété grâce à l'id
        $category = $categoryRepository->find($id);

        // remove = supprime/enlève la catégorie dont l'id a été précisé
        $entityManager->remove($category);

        // envoie l'information en bdd
        $entityManager->flush();

        // message d'info pour indiquer que la catégorie a été supprimée
        $this->addFlash(
            'success',
            'La catégorie '. $category->getTitle().' a bien été supprimée !'
        );

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