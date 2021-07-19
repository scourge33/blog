<?php
namespace App\Controller\Front;

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

class FrontArticleController extends AbstractController
{
    //affiche tous les articles
        /**
         * @Route("/articles", name="frontArticleList")
         */
        public function articleList(articleRepository $articleRepository)
        {
            $articles = $articleRepository->findAll();

              return $this->render( 'front/front_article_list.html.twig', [
                      'articles'=>$articles
              ]);
        }

        // affiche 1 article
        /**
         * @Route("/articles/{id}", name="frontArticleShow")
         */
        public function articleShow($id, ArticleRepository $articleRepository)
        {
            $article = $articleRepository->find($id);

            // affiche un message d'erreur si un article n'existe pas
            if (is_null($article)) {
                throw new NotFoundHttpException();
            }

            return $this->render( 'front/front_article_show.html.twig', [
                'article'=>$article]);
        }

        // création de l'url search pour chercher les mots communs aux articles
        /**
         * @Route("/search", name="frontSearch")
         */
        // fonction qui va chercher la variable request pour exécuter une requête
        public function search(ArticleRepository $articleRepository, Request $request)
        {
            // variable qui permet de rechercher le mot clé
            $term = $request->query->get('q');

            // connecte le controller au fichier admin_article_search.html.twig
            $articles = $articleRepository->searchByTerm($term);

            return $this->render('front/front_article_search.html.twig', [
                'articles' => $articles,
                'term' => $term
            ]);
        }
}