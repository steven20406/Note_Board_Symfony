<?php
namespace BankingBundle\Tests\Entity;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class EntityTest extends WebTestCase
{
    protected $em;

    /**
     * Initial setup data fixture
     * Initial setup EntityManager
     */
    protected function setUp() {
        $loadData = [
            'BankingBundle\Tests\DataFixtures\ORM\LoadTransactionEntityData'
        ];

        $this->loadFixtures($loadData, 'banking');

        $kernel = self::bootKernel();
        $this->em = $kernel->getContainer()->get('doctrine')->getManager('banking');
    }

    /**
     * Test User entity
     */
    public function testUser() {
        $user = $this->em->getRepository('BankingBundle:User')->findOneBy(['username' => 'testbbb']);

        $this->assertEquals('testbbb', $user->getUsername());
        $this->assertEquals(100000, $user->getBalance());
        $this->assertEquals(1, count($user->getTransactions()));

        return $user;
    }

    /**
     *Test Transaction entity
     *
     * @depends testUser
     * @param $user
     */
    public function testTransaction($user) {
        $trans = $this->em->getRepository('BankingBundle:Transaction')
            ->findOneBy(['userId' => $user->getId()]);

        $this->assertGreaterThan(0, $trans->getId());
        $this->assertEquals(12345, $trans->getAmount());
        $this->assertEquals(1012345, $trans->getBalance());
        $this->assertEquals($user->getId(), $trans->getUserId()->getId());
        $this->assertGreaterThan(0, count($user->getTransactions()));
    }
}
