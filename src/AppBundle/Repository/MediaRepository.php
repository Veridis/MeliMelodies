<?php

namespace AppBundle\Repository;

class MediaRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllActives()
    {
        $qb = $this->createQueryBuilder('media')
            ->leftJoin('media.gallery', 'gallery')
            ->addSelect('gallery')
            ->where('media.active = 1')
            ->orderBy('media.createdDate', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }
}
