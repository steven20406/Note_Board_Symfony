<?php

namespace BankingBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

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
        $em = $this->getEntityManager('banking');
        $em->beginTransaction();
        try {
            $query = $em->createQueryBuilder()
                    ->update('BankingBundle:User', 'u')
                    ->where('u.id = :id')
                    ->set('u.balance', 'u.balance + :amount')
                    ->setParameter('id', $id)
                    ->setParameter('amount', $amount)
                    ->getQuery()->execute();
            $em->commit();
            //throw new Exception('aa2');
        } catch (\Exception $e) {
            $em->rollback();
        }
    }
}