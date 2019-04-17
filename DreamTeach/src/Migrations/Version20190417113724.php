<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190417113724 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE file_upload (id INT AUTO_INCREMENT NOT NULL, id_student_id INT NOT NULL, id_session_id INT NOT NULL, filename VARCHAR(255) NOT NULL, INDEX IDX_AFAAC0A06E1ECFCD (id_student_id), INDEX IDX_AFAAC0A0C4B56C08 (id_session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file_upload ADD CONSTRAINT FK_AFAAC0A06E1ECFCD FOREIGN KEY (id_student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE file_upload ADD CONSTRAINT FK_AFAAC0A0C4B56C08 FOREIGN KEY (id_session_id) REFERENCES session (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE file_upload');
    }
}
