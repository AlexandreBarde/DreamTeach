<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190204092454 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE school (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL, address VARCHAR(50) NOT NULL, postalCode VARCHAR(5) NOT NULL, city VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, startingTime TIME NOT NULL, endingTime TIME NOT NULL, date DATE NOT NULL, place VARCHAR(100) NOT NULL, maxNbParticipant INT NOT NULL, isVirtual TINYINT(1) NOT NULL, organizerID INT DEFAULT NULL, subjectID INT DEFAULT NULL, INDEX subjectID (subjectID), INDEX organizerID (organizerID), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sessionparticipants (sessionID INT NOT NULL, studentID INT NOT NULL, INDEX IDX_D38DDC1B23E953E (sessionID), INDEX IDX_D38DDC1BA3D10F50 (studentID), PRIMARY KEY(sessionID, studentID)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, lastName VARCHAR(40) NOT NULL, firstName VARCHAR(40) NOT NULL, emailAddress VARCHAR(60) NOT NULL, biography VARCHAR(255) NOT NULL, password VARCHAR(20) NOT NULL, avatar VARCHAR(100) NOT NULL, xpWon VARCHAR(5) NOT NULL, trainingID INT DEFAULT NULL, INDEX trainingID (trainingID), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE givenrecompenses (studentID INT NOT NULL, badgeID INT NOT NULL, INDEX IDX_CDA15877A3D10F50 (studentID), INDEX IDX_CDA1587796B83874 (badgeID), PRIMARY KEY(studentID, badgeID)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subjectlevel (studentID INT NOT NULL, subjectID INT NOT NULL, INDEX IDX_550538D3A3D10F50 (studentID), INDEX IDX_550538D35621423 (subjectID), PRIMARY KEY(studentID, subjectID)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(40) NOT NULL, duration VARCHAR(20) NOT NULL, schoolID INT DEFAULT NULL, INDEX schoolID (schoolID), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE badge (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D432C39171 FOREIGN KEY (organizerID) REFERENCES student (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D45621423 FOREIGN KEY (subjectID) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE sessionparticipants ADD CONSTRAINT FK_D38DDC1B23E953E FOREIGN KEY (sessionID) REFERENCES session (id)');
        $this->addSql('ALTER TABLE sessionparticipants ADD CONSTRAINT FK_D38DDC1BA3D10F50 FOREIGN KEY (studentID) REFERENCES student (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33A0A55892 FOREIGN KEY (trainingID) REFERENCES training (id)');
        $this->addSql('ALTER TABLE givenrecompenses ADD CONSTRAINT FK_CDA15877A3D10F50 FOREIGN KEY (studentID) REFERENCES student (id)');
        $this->addSql('ALTER TABLE givenrecompenses ADD CONSTRAINT FK_CDA1587796B83874 FOREIGN KEY (badgeID) REFERENCES badge (id)');
        $this->addSql('ALTER TABLE subjectlevel ADD CONSTRAINT FK_550538D3A3D10F50 FOREIGN KEY (studentID) REFERENCES student (id)');
        $this->addSql('ALTER TABLE subjectlevel ADD CONSTRAINT FK_550538D35621423 FOREIGN KEY (subjectID) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8F70E4D61D FOREIGN KEY (schoolID) REFERENCES school (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8F70E4D61D');
        $this->addSql('ALTER TABLE sessionparticipants DROP FOREIGN KEY FK_D38DDC1B23E953E');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D432C39171');
        $this->addSql('ALTER TABLE sessionparticipants DROP FOREIGN KEY FK_D38DDC1BA3D10F50');
        $this->addSql('ALTER TABLE givenrecompenses DROP FOREIGN KEY FK_CDA15877A3D10F50');
        $this->addSql('ALTER TABLE subjectlevel DROP FOREIGN KEY FK_550538D3A3D10F50');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33A0A55892');
        $this->addSql('ALTER TABLE givenrecompenses DROP FOREIGN KEY FK_CDA1587796B83874');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D45621423');
        $this->addSql('ALTER TABLE subjectlevel DROP FOREIGN KEY FK_550538D35621423');
        $this->addSql('DROP TABLE school');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE sessionparticipants');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE givenrecompenses');
        $this->addSql('DROP TABLE subjectlevel');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE badge');
        $this->addSql('DROP TABLE subject');
    }
}
