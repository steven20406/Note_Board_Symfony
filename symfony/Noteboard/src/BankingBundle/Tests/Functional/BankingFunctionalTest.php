<?php

namespace Tests\BankingBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class BankingFunctionalTest extends WebTestCase
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
     * Test function indexAction
     */
    public function testIndex() {
        $client = static:: createClient();

        $crawler = $client->request('GET', '/banking/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('User list', $crawler->filter('#container h1')->text());

        $form = $crawler->selectButton('提交')->form();
        $randNo = rand(1000, 10000);
        $username = "Steven No.$randNo";
        $form['user[username]'] = $username;
        $form['user[balance]'] = rand(10000, 1000000);
        $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/banking/');

        $link = $crawler->filter("a:contains('$username')")
            ->eq(0)
            ->link();

        $crawler = $client->click($link);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Manage account',$crawler->filter('#container h1')->text());

        $user = $this->em->getRepository('BankingBundle:User')->findOneBy(['username' => $username]);
        $this->assertGreaterThan(1, $user->getId());
    }

    /**
     * Test function saveAction
     */
    public function testSave() {
        $client = static:: createClient();

        $crawler = $client->request('GET', '/banking/');

        $link = $crawler->filter("a:contains('testbbb')")
            ->eq(0)
            ->link();
        $crawler = $client->click($link);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Save')->form();
        $form['transaction[amount]'] = 10;
        $client->submit($form);

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'error'
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('withdraw')->form();
        $form['transaction[amount]'] = 10;
        $client->submit($form);

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'error'
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('save')->form();
        $form['transaction[amount]'] = 'testcode';
        $client->submit($form);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());

        $user = $this->em->getRepository('BankingBundle:User')->find(1);
        $this->assertEquals(3, count($user->getTransactions()));
    }

    /**
     * Test transaction 0 input, return exception page
     */
    public function testZeroTransaction() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/banking/save/1');

        $form = $crawler->selectButton('Save')->form();
        $form['transaction[amount]'] = 0;
        $client->submit($form);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    /**
     * Test withdraw money greater than balance, got error message
     */
    public function testNotEnoughMoney() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/banking/save/1');

        $form = $crawler->selectButton('Withdraw')->form();
        $form['transaction[amount]'] = 1000000;
        $client->submit($form);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }
}
