<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Up : Create table user and transaction, set foreign key
 * Down : Drop user and transaction table, drop foreign key
 *
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171201025730 extends AbstractMigration {
    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema) {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id BIGINT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, balance BIGINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id BIGINT AUTO_INCREMENT NOT NULL, amount BIGINT NOT NULL, at DATETIME NOT NULL, balance BIGINT NOT NULL, userId BIGINT DEFAULT NULL, INDEX IDX_723705D164B64DCC (userId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D164B64DCC FOREIGN KEY (userId) REFERENCES user (id)');
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function down(Schema $schema) {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D164B64DCC');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE transaction');
    }
}
