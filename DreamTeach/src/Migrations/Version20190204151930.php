<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190204151930 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE student CHANGE lastName lastName VARCHAR(255) NOT NULL, CHANGE firstName firstName VARCHAR(255) NOT NULL, CHANGE emailAddress emailAddress VARCHAR(255) NOT NULL, CHANGE biography biography VARCHAR(255) DEFAULT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE avatar avatar VARCHAR(255) DEFAULT NULL, CHANGE xpWon xpWon INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE student CHANGE lastName lastName VARCHAR(40) NOT NULL COLLATE utf8_general_ci, CHANGE firstName firstName VARCHAR(40) NOT NULL COLLATE utf8_general_ci, CHANGE emailAddress emailAddress VARCHAR(60) NOT NULL COLLATE utf8_general_ci, CHANGE biography biography VARCHAR(255) NOT NULL COLLATE utf8_general_ci, CHANGE password password VARCHAR(20) NOT NULL COLLATE utf8_general_ci, CHANGE avatar avatar VARCHAR(100) NOT NULL COLLATE utf8_general_ci, CHANGE xpWon xpWon VARCHAR(5) NOT NULL COLLATE utf8_general_ci');
    }
}
