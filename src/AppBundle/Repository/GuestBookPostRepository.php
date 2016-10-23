<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GuestBookPostRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAllUnarchived()
    {
        $qb = $this->createQueryBuilder('post')
            ->where('post.archived <> 1')
            ->orderBy('post.date', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }
}
