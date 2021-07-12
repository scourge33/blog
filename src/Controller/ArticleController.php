<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Tag;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    //création de l'URL pour afficher les insert
    /**
     * @Route("/articles/insert", name="articleInsert")
     */
    public function insertArticle(
        EntityManagerInterface $entityManager,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository
    )
    {
        // new sert à créer une nouvelle instance de la class article
        $article = new Article();

        // setter = renseigne le titre, le contenu, si l'article est publié ou non
        //et la date de crétaion de l'article
        $article->setTitle("Titre de l'article");
        $article->setContent("Contenu de l'article");
        $article->setIsPublished(true);
        $article->setCreatedAt(new \DateTime('NOW'));

        // garde l'événement en attente
        $category = $categoryRepository->find(1);

        $article->setCategory($category);

        $tag = $tagRepository->findOneBy(['title' => 'info']);

        // ajout de nouveaux tags
        if (is_null($tag)) {
            $tag = new Tag();
            $tag->setTitle("info");
            $tag->setColor("blue");
        }

        $entityManager->persist($article);

        $article->setTag($tag);

        // prépare l'entité à la création
        $entityManager->persist($article);
        // envoie les informations en bdd
        $entityManager->flush();

        // redirectToRoute?(a voir)
        return $this->render('article_list.html.twig');
    }

    //URL pour mettre à jour les articles
    /**
     * @Route("/articles/update/{id}", name="articleUpdate")
     */
    public function updateArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        // récupère la propriété grâce à l'id
        $article = $articleRepository->find($id);

        // met à jour le titre de l'article
        $article->setTitle("update titre");

        // prépare l'entité à la création
        $entityManager->persist($article);
        // envoie les informations en bdd
        $entityManager->flush();

        return new Response('modif ok');
    }

    //affiche tous les articles
        /**
         * @Route("/articles", name="articleList")
         */
        public function articleList(articleRepository $articleRepository)
        {
            $articles = $articleRepository->findAll();

              return $this->render( 'article_list.html.twig', [
                      'articles'=>$articles
              ]);
        }

        // affiche 1 article
        /**
         * @Route("/articles/{id}", name="articleShow")
         */
        public function articleShow($id, ArticleRepository $articleRepository)
        {
            $article = $articleRepository->find($id);

            // affiche un message d'erreur si un article n'existe pas
            if (is_null($article)) {
                throw new NotFoundHttpException();
            }

            return $this->render( 'article_show.html.twig', [
                'article'=>$article]);
        }

        // création de l'url search pour chercher les mots communs aux articles
        /**
         * @Route("/search", name="search")
         */
        // fonction qui va chercher la variable request pour exécuter une requête
        public function search(ArticleRepository $articleRepository, Request $request)
        {
            // variable qui permet de rechercher le mot clé
            $term = $request->query->get('q');

            // connecte le controller au fichier article_search.html.twig
            $articles = $articleRepository->searchByTerm($term);

            return $this->render('article_search.html.twig', [
                'articles' => $articles,
                'term' => $term
            ]);
        }
}