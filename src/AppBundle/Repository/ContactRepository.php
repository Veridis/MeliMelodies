<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ContactRepository extends EntityRepository
{
    public function findAllOrdered()
    {
        $qb = $this->createQueryBuilder('contact')
            ->orderBy('contact.date', 'DESC')
            ->addOrderBy('contact.id', 'DESC');

        return $qb->getQuery()->getResult();
    }
}
