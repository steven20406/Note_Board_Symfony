<?php

namespace BankingBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TransactionRepository extends EntityRepository
{
    /**
     * Get all transaction record
     *
     * @param $id
     * @return mixed
     */
    public function getTransaction($id)
    {
        try {
            $query = $this->getEntityManager('banking')
                    ->createQueryBuilder()
                    ->select('t')
                    ->from('BankingBundle:Transaction', 't')
                    ->where('t.userId = :id')
                    ->setParameter('id', $id)
                    ->getQuery()->execute();
        } catch (\Exception $e) {
        }

        return $query;
    }
}