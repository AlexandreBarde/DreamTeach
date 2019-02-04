<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190204091124 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE session CHANGE organizerID organizerID INT DEFAULT NULL, CHANGE subjectID subjectID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sessionparticipants DROP invitationAccepted');
        $this->addSql('ALTER TABLE sessionparticipants RENAME INDEX studentid TO IDX_D38DDC1BA3D10F50');
        $this->addSql('ALTER TABLE student CHANGE trainingID trainingID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE givenrecompenses DROP obtentionDate');
        $this->addSql('ALTER TABLE givenrecompenses RENAME INDEX badgeid TO IDX_CDA1587796B83874');
        $this->addSql('ALTER TABLE subjectlevel DROP level');
        $this->addSql('ALTER TABLE subjectlevel RENAME INDEX subjectid TO IDX_550538D35621423');
        $this->addSql('ALTER TABLE training CHANGE schoolID schoolID INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE givenrecompenses ADD obtentionDate DATE NOT NULL');
        $this->addSql('ALTER TABLE givenrecompenses RENAME INDEX idx_cda1587796b83874 TO badgeID');
        $this->addSql('ALTER TABLE session CHANGE organizerID organizerID INT NOT NULL, CHANGE subjectID subjectID INT NOT NULL');
        $this->addSql('ALTER TABLE sessionparticipants ADD invitationAccepted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE sessionparticipants RENAME INDEX idx_d38ddc1ba3d10f50 TO studentID');
        $this->addSql('ALTER TABLE student CHANGE trainingID trainingID INT NOT NULL');
        $this->addSql('ALTER TABLE subjectlevel ADD level INT NOT NULL');
        $this->addSql('ALTER TABLE subjectlevel RENAME INDEX idx_550538d35621423 TO subjectID');
        $this->addSql('ALTER TABLE training CHANGE schoolID schoolID INT NOT NULL');
    }
}
