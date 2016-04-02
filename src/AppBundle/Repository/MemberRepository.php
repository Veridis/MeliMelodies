<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MemberRepository extends EntityRepository
{
    public function findUnarchived()
    {
        $qb = $this->createQueryBuilder('m')
            ->leftJoin('m.photo', 'photo')
            ->addSelect('photo')
            ->where('m.archived = 0')
        ;

        return $qb->getQuery()->getResult();
    }
}
