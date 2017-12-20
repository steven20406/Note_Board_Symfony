<?php

namespace BankingBundle\Tests\DataFixtures\ORM;

use BankingBundle\Entity\Transaction;
use BankingBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTransactionEntityData extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager) {
        $user = new User();
        $user->setUsername('testbbb');
        $user->setBalance(100000);
        $user->setVersion(1);
        $manager->persist($user);

        $trans = new Transaction();
        $trans->setUserId($user);
        $trans->setAmount(12345);
        $trans->setAt(new \DateTime());
        $trans->setBalance(1012345);
        $manager->persist($trans);

        $manager->flush();
    }
}