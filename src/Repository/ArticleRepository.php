<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }
    
    public function findBySearch($search)
    {
        $query_builder =  $this->createQueryBuilder('a');
        
        if (!empty($search->getSearch()))
        {
            $query_builder
                ->where('MATCH_AGAINST(a.title, a.text) AGAINST(:searchterm boolean)>0')
                ->setParameter('searchterm', $search->getSearch());
        }
        
        if (!empty($search->getCategories()))
        {
            $query_builder
                ->innerJoin('a.categories', 'c')
                ;//->where('c.id IN (:categories)')
                //->setParameter('categories', $search->getCategories());*/
        }
        
        return $query_builder
            ->getQuery()
            ->getResult();
    }
}
