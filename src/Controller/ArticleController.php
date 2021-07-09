<?php
namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
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
        public function search(ArticleRepository $articleRepository)
        {
            // variable qui va permettre de choisir le mot commun aux articles
            $term = 'Jean';

            // connecte le controller au fichier article_search.html.twig
            $articles = $articleRepository->searchByTerm($term);

            return $this->render('article_search.html.twig', [
                'articles' => $articles
            ]);
        }
}