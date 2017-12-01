<?php

namespace Application\Migrations;

use BankingBundle\Entity\User;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Up : Generate 20 data in user table
 * Down : Clear all table data and reset primary key auto_increment number to 10000
 *
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171201032133 extends AbstractMigration implements ContainerAwareInterface
{

    private $container;

    /**
     * Set container
     *
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
    }

    /**
     * Add 20 data into user table
     *
     * @param Schema $schema
     */
    public function postUp(Schema $schema) {
        $em = $this->container->get('doctrine')->getManager('banking');

        for($i = 1; $i <= 20; $i++){
            $user = new User();
            $user->setUsername('Steven No.'.$i);
            $user->setBalance(rand(10000, 1000000));
            $em->persist($user);
        }
        $em->flush();
    }

    /**
     * Delete all data in user and transaction table
     * Reset the id auto_increment key to 10000
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     */
    public function postDown(Schema $schema) {
        $qb = $this->connection->createQueryBuilder();
        $qb->delete('transaction')->execute();
        $qb->delete('user')->execute();
        $this->connection->exec('alter table user auto_increment = 10000');
        $this->connection->exec('alter table transaction auto_increment = 10000');
    }
}
