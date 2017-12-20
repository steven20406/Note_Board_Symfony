<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171219145946 extends AbstractMigration
{
    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema)
    {
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.1", 992840, 1)');
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.2", 432932, 1)');
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.3", 679851, 1)');
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.4", 259380, 1)');
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.5", 88677, 1)');
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.6", 424059, 1)');
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.7", 911033, 1)');
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.8", 737507, 1)');
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.9", 38783, 1)');
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.10", 217975, 1)');
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.11", 408003, 1)');
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.12", 558868, 1)');
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.13", 719553, 1)');
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.14", 641569, 1)');
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.15", 237652, 1)');
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.16", 546073, 1)');
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.17", 686016, 1)');
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.18", 936890, 1)');
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.19", 541026, 1)');
        $this->connection->exec('insert into user (username, balance, version) value ("Steven No.20", 916510, 1)');
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema)
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->delete('transaction_list')->execute();
        $qb->delete('user')->execute();
        $this->connection->exec('alter table user auto_increment = 10000');
        $this->connection->exec('alter table transaction_list auto_increment = 10000');
    }
}
