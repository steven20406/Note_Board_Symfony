<?php

namespace BankingBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TransactionRepository extends EntityRepository
{
    /**
     * Get all transaction record
     *
     * @param $userId
     * @return mixed
     * @throws \Exception
     */
    public function getTransaction($userId) {
        $em = $this->getEntityManager('banking');
        $query = $em->createQueryBuilder()
            ->select('t')
            ->from('BankingBundle:Transaction', 't')
            ->where('t.userId = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()->execute();

        return $query;
    }
}