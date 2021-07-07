<?php
namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

            return $this->render( 'article_show.html.twig', [
                'article'=>$article]);
        }
}