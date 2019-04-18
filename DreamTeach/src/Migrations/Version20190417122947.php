<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190417122947 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_upload DROP FOREIGN KEY FK_AFAAC0A06E1ECFCD');
        $this->addSql('DROP INDEX IDX_AFAAC0A06E1ECFCD ON file_upload');
        $this->addSql('ALTER TABLE file_upload DROP id_student_id, CHANGE id_session_id id_session_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_upload ADD id_student_id INT NOT NULL, CHANGE id_session_id id_session_id INT NOT NULL');
        $this->addSql('ALTER TABLE file_upload ADD CONSTRAINT FK_AFAAC0A06E1ECFCD FOREIGN KEY (id_student_id) REFERENCES student (id)');
        $this->addSql('CREATE INDEX IDX_AFAAC0A06E1ECFCD ON file_upload (id_student_id)');
    }
}
