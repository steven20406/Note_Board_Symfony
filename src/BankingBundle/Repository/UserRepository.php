<?php

namespace BankingBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * Execute transaction event
     *
     * @param $id
     * @param $amount
     */
    public function transactionEvent($id, $amount)
    {
        $em = $this->getEntityManager('banking')
                ->createQueryBuilder()
                ->update('BankingBundle:User', 'u')
                ->where('u.id = :id')
                ->set('u.balance' , 'u.balance + :amount')
                ->setParameter('id', $id)
                ->setParameter('amount', $amount)
                ->getQuery()->execute();
    }
}