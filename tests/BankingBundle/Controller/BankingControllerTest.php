<?php

namespace Tests\BankingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BankingControllerTest extends WebTestCase
{
    public function testIndex() {
        $client = static :: createClient();

        $crawler = $client->request('GET', '/banking/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('User list', $crawler->filter('#container h1')->text());

        $form = $crawler->selectButton('提交')->form();
        $form['user[username]'] = 'Steven';
        $form['user[balance]'] = 12345;
        $client->submit($form);

        $link = $crawler->filter('a:contains("Steven")')
                ->eq(1)
                ->link();
        $crawler = $client->click($link);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSave() {
        $client = static :: createClient();

        $crawler = $client->request('GET', '/banking/save/10000');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Save')->form();
        $form['transaction[amount]'] = 10;
        $client->submit($form);

        $this->assertTrue($client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
        ),
                'error');
    }

    public function testZeroTransaction() {
        $client = static :: createClient();

        $crawler = $client->request('GET', '/banking/save/10000');

        $form = $crawler->selectButton('Save')->form();
        $form['transaction[amount]'] = 0;
        $client->submit($form);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    public function testNotEnoughMoney() {
        $client = static :: createClient();

        $crawler = $client->request('GET', '/banking/save/10000');

        $form = $crawler->selectButton('Withdraw')->form();
        $form['transaction[amount]'] = 10000000000;
        $client->submit($form);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }
}
