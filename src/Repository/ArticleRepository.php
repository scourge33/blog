<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // fonction search
    public function searchByTerm($term)
    {
        $queryBuilder = $this->createQueryBuilder( 'article');

        // variable qui va permettre de parcourir le contenu des articles
        $query = $queryBuilder
            ->select('article')

            // fait la jointure entre la catégorie et le tag de l'article
            ->leftJoin('article.category',  'category' )
            ->leftJoin('article.tag', 'tag')

            // va chercher le contenu et le nom de l'article ainsi que les noms des catégories
            // et des tags qui sont en communs
            ->where('article.content LIKE :term')
            ->orWhere('article.title LIKE :term')
            ->orWhere('category.title LIKE :term')
            ->orWhere('tag.title LIKE :term')
            
            ->setParameter('term', '%'.$term.'%')
            ->getQuery();

        // affiche
        return $query->getResult();
    }
    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
