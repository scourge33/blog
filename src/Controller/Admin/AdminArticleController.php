<?php
namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Tag;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminArticleController extends AbstractController
{
    //création de l'URL pour ajouter des articles
    /**
     * @Route("/admin/articles/insert", name="adminArticleInsert")
     */
    public function insertArticle(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        // new sert à créer une nouvelle instance de la classe article
        $article = new Article();

        // créé le formulaire
        $articleForm = $this->createForm(ArticleType::class, $article);

        // relie le formulaire au bouton submit
        $articleForm->handleRequest($request);

        // "si le formulaire est publié et valide"
        if($articleForm->isSubmitted() && $articleForm->isValid()) {

            $imageFile = $articleForm->get('image')->getData();

            if($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFileName = $slugger->slug($originalFilename);

                $newFileName = $safeFileName.'_'.uniqid().'.'.$imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('upload'),
                    $newFileName
                );

                $article->setImage($newFileName);
            }
            // prépare l'entité à la création
            $entityManager->persist($article);

            // envoie les informations en bdd
            $entityManager->flush();

            // message d'info pour indiquer que l'article a été créé
            $this->addFlash(
                'success',
                'L\'article '. $article->getTitle().' a bien été créé !'
            );

            //si ok on renvoi sur la page list pour voir le nouvel article
            return $this->redirectToRoute('adminArticleList');
        }

        // renvoie sur la page liste
        return $this->render('admin/admin_article_insert.html.twig', [
            'articleForm' => $articleForm->createView()
        ]);
    }
  //  {
        // new sert à créer une nouvelle instance de la classe article
     //   $article = new Article();

        // setter = renseigne le titre, le contenu, si l'article est publié ou non
        //et la date de création de l'article
    //    $article->setTitle("Titre de l'article");
    //    $article->setContent("Contenu de l'article");
    //    $article->setIsPublished(true);
    //    $article->setCreatedAt(new \DateTime('NOW'));

        // garde l'événement en attente
    //   $category = $categoryRepository->find(1);

    //    $article->setCategory($category);

    //    $tag = $tagRepository->find(1);

        // ajout de nouveaux tags
    //    if (is_null($tag)) {
    //        $tag = new Tag();
    //        $tag->setTitle("info");
    //        $tag->setColor("blue");
    //    }

    //    $entityManager->persist($tag);

    //    $article->setTag($tag);

        // prépare l'entité à la création
    //    $entityManager->persist($article);
        // envoie les informations en bdd
    //    $entityManager->flush();

    //    return $this->redirectToRoute("adminArticleList"); // nom de la route = name
  //  }

    //URL pour mettre à jour les articles
    /**
     * @Route("/admin/articles/update/{id}", name="adminArticleUpdate")
     */
    public function updateArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager, Request $request)
    {
        // récupère la propriété grâce à l'id
        $article = $articleRepository->find($id);

        // propose le formulaire pour modifier l'article
        $articleForm = $this->createForm(ArticleType::class, $article);

        // lie le formulaire aux modifications
        $articleForm->handleRequest($request);

        // Met à jour si les conditions sont remplies correctement
        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            // prépare l'entité à la création
            $entityManager->persist($article);
            // envoie les informations en bdd
            $entityManager->flush();
            // message d'info pour indiquer que l'article a été maj
            $this->addFlash(
                'success',
                'L\'article '. $article->getTitle().' a bien été mis à jour !'
            );

            return $this->redirectToRoute('adminArticleList');
        }

        //renvoi du formulaire sur une page vue si le formulaire n est pas validé
        return $this->render('Admin/admin_article_insert.html.twig',['articleForm'=> $articleForm ->createView()] );
    }

    // création de l'URL pour supprimer un article grâce à son id
    /**
     * @Route("/admin/articles/delete/{id}", name="adminArticleDelete")
     */
    public function deleteArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        // récupère la propriété grâce à l'id
        $article = $articleRepository->find($id);

        // remove = supprime/enleve l'article dont l'id a été précisé
        $entityManager->remove($article);

        // envoie l'information en bdd
        $entityManager->flush();

        // message d'info pour indiquer que l'article a été supprimé
        $this->addFlash(
            'success',
            'L\'article '. $article->getTitle().' a bien été supprimé !'
        );

        // renvoie sur la page liste
        return $this->redirectToRoute("adminArticleList");
    }

    //affiche tous les articles
        /**
         * @Route("/admin/articles", name="adminArticleList")
         */
        public function articleList(articleRepository $articleRepository)
        {
            $articles = $articleRepository->findAll();

              return $this->render( 'admin/admin_article_list.html.twig', [
                      'articles'=>$articles
              ]);
        }

        // affiche 1 article
        /**
         * @Route("/admin/articles/{id}", name="adminArticleShow")
         */
        public function articleShow($id, ArticleRepository $articleRepository)
        {
            $article = $articleRepository->find($id);

            // affiche un message d'erreur si un article n'existe pas
            if (is_null($article)) {
                throw new NotFoundHttpException();
            }

            return $this->render( 'admin/admin_article_show.html.twig', [
                'article'=>$article]);
        }
}