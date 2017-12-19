<?php

namespace Application\Migrations;

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
class Version20171201032133 extends AbstractMigration implements ContainerAwareInterface {

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
    public function up(Schema $schema) {
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema) {
    }

    /**
     * Add 20 data into user table
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function postUp(Schema $schema) {

        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->connection->exec('insert into user (username, balance) value ("Steven No.1", 992840)');
        $this->connection->exec('insert into user (username, balance) value ("Steven No.2", 432932)');
        $this->connection->exec('insert into user (username, balance) value ("Steven No.3", 679851)');
        $this->connection->exec('insert into user (username, balance) value ("Steven No.4", 259380)');
        $this->connection->exec('insert into user (username, balance) value ("Steven No.5", 88677)');
        $this->connection->exec('insert into user (username, balance) value ("Steven No.6", 424059)');
        $this->connection->exec('insert into user (username, balance) value ("Steven No.7", 911033)');
        $this->connection->exec('insert into user (username, balance) value ("Steven No.8", 737507)');
        $this->connection->exec('insert into user (username, balance) value ("Steven No.9", 38783)');
        $this->connection->exec('insert into user (username, balance) value ("Steven No.10", 217975)');
        $this->connection->exec('insert into user (username, balance) value ("Steven No.11", 408003)');
        $this->connection->exec('insert into user (username, balance) value ("Steven No.12", 558868)');
        $this->connection->exec('insert into user (username, balance) value ("Steven No.13", 719553)');
        $this->connection->exec('insert into user (username, balance) value ("Steven No.14", 641569)');
        $this->connection->exec('insert into user (username, balance) value ("Steven No.15", 237652)');
        $this->connection->exec('insert into user (username, balance) value ("Steven No.16", 546073)');
        $this->connection->exec('insert into user (username, balance) value ("Steven No.17", 686016)');
        $this->connection->exec('insert into user (username, balance) value ("Steven No.18", 936890)');
        $this->connection->exec('insert into user (username, balance) value ("Steven No.19", 541026)');
        $this->connection->exec('insert into user (username, balance) value ("Steven No.20", 916510)');
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
