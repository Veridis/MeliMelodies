<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class NewsRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAllWithJoin()
    {
        $qb = $this->createQueryBuilder('news')
            ->leftJoin('news.author', 'author')
            ->addSelect('author')
            ->orderBy('news.createdDate', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @return array
     */
    public function findAllActives()
    {
        $qb = $this->createQueryBuilder('news')
            ->leftJoin('news.author', 'author')
            ->addSelect('author')
            ->where('news.active = 1')
            ->orderBy('news.createdDate', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $slug
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneBySlug($slug)
    {
        $qb = $this->createQueryBuilder('news')
            ->leftJoin('news.author', 'author')
            ->addSelect('author')
            ->orderBy('news.createdDate', 'DESC')
            ->where('news.slug = :slug')
            ->setParameter('slug', $slug)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }
}
