<?php

namespace Tests\BankingBundle\Repository;

use BankingBundle\Repository\TransactionRepository;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class TransactionRepositoryTest extends WebTestCase
{
    protected $em;

    /**
     * Initial setup data fixture
     * Initial setup EntityManager
     */
    protected function setUp() {
        $userTransactionData = [
                'BankingBundle\Tests\DataFixtures\ORM\LoadTransactionEntityData'
        ];

        $this->loadFixtures($userTransactionData, 'banking');

        $kernel = self::bootKernel();

        $this->em = $kernel->getContainer()->get('doctrine')->getManager('banking');
    }

    /**
     * Test function getTransaction
     * @throws \Exception
     */
    public function testGetTransaction() {
        $repo = $this->em->getRepository('BankingBundle:Transaction');

        $transArray = $repo->getTransaction(1);

        if(count($transArray) > 0) {
            foreach ($transArray as $trans)
            $this->assertEquals(1, $trans->getUserId()->getId());
        }

        $stub = $this->createMock(TransactionRepository::class);

        $stub->method('getTransaction')
            ->will($this->throwException(new \Exception()));
    }
}
