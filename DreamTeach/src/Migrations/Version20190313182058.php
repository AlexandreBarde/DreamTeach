<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190313182058 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE badge (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE friendship_relation (id INT AUTO_INCREMENT NOT NULL, student_1_id INT DEFAULT NULL, student_2_id INT DEFAULT NULL, is_accepted TINYINT(1) NOT NULL, INDEX IDX_D5634873CFF02722 (student_1_id), INDEX IDX_D5634873DD4588CC (student_2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grade (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, id_receiver_id INT NOT NULL, id_sender_id INT NOT NULL, content LONGTEXT NOT NULL, date DATETIME NOT NULL, INDEX IDX_B6BD307FD5412041 (id_receiver_id), INDEX IDX_B6BD307F76110FBA (id_sender_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE qcm (id INT AUTO_INCREMENT NOT NULL, author_id_id INT NOT NULL, deadline DATETIME DEFAULT NULL, visible TINYINT(1) NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_D7A1FEF469CCBE9A (author_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, theme INT DEFAULT NULL, content VARCHAR(1000) NOT NULL, INDEX IDX_B6F7494EF675F31B (author_id), INDEX theme (theme), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_list (id INT AUTO_INCREMENT NOT NULL, question_id_id INT NOT NULL, qcm_id_id INT NOT NULL, INDEX IDX_1A2615F74FAF8F53 (question_id_id), INDEX IDX_1A2615F7F16A9A2D (qcm_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE response (id INT AUTO_INCREMENT NOT NULL, question_id_id INT NOT NULL, content VARCHAR(1000) NOT NULL, rightanswer TINYINT(1) NOT NULL, INDEX IDX_3E7B0BFB4FAF8F53 (question_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE result (id INT AUTO_INCREMENT NOT NULL, qcm_id_id INT NOT NULL, user_id_id INT NOT NULL, result DOUBLE PRECISION NOT NULL, visible TINYINT(1) NOT NULL, INDEX IDX_136AC113F16A9A2D (qcm_id_id), INDEX IDX_136AC1139D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL, address VARCHAR(50) NOT NULL, postalCode VARCHAR(5) NOT NULL, city VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, startingTime TIME NOT NULL, endingTime TIME NOT NULL, date DATE NOT NULL, place VARCHAR(100) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, maxNbParticipant INT NOT NULL, isVirtual TINYINT(1) NOT NULL, vocalSoftware VARCHAR(100) DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, closed TINYINT(1) NOT NULL, comment VARCHAR(255) DEFAULT NULL, organizerID INT DEFAULT NULL, subjectID INT DEFAULT NULL, INDEX subjectID (subjectID), INDEX organizerID (organizerID), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sessionparticipants (sessionID INT NOT NULL, studentID INT NOT NULL, INDEX IDX_D38DDC1B23E953E (sessionID), INDEX IDX_D38DDC1BA3D10F50 (studentID), PRIMARY KEY(sessionID, studentID)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Sessioncomment (id INT AUTO_INCREMENT NOT NULL, comment VARCHAR(255) DEFAULT NULL, note INT NOT NULL, idSession INT DEFAULT NULL, idStudent INT DEFAULT NULL, INDEX IDX_CF48C76EA79AC4C1 (idStudent), INDEX idSession (idSession), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) NOT NULL, lastName VARCHAR(255) NOT NULL, firstName VARCHAR(255) NOT NULL, emailAddress VARCHAR(255) NOT NULL, biography VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, xpWon INT DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, birth_date DATETIME DEFAULT NULL, reset_password TINYINT(1) NOT NULL, reset_id VARCHAR(255) DEFAULT NULL, trainingID INT DEFAULT NULL, gradeId INT DEFAULT NULL, INDEX IDX_B723AF33A0F967B0 (gradeId), INDEX trainingID (trainingID), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE givenrecompenses (studentID INT NOT NULL, badgeID INT NOT NULL, INDEX IDX_CDA15877A3D10F50 (studentID), INDEX IDX_CDA1587796B83874 (badgeID), PRIMARY KEY(studentID, badgeID)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject_level (studentID INT NOT NULL, subjectID INT NOT NULL, INDEX IDX_8B790DCBA3D10F50 (studentID), INDEX IDX_8B790DCB5621423 (subjectID), PRIMARY KEY(studentID, subjectID)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liked_profile (studentID1 INT NOT NULL, studentID2 INT NOT NULL, INDEX IDX_FB4FE945E8146F4C (studentID1), INDEX IDX_FB4FE945711D3EF6 (studentID2), PRIMARY KEY(studentID1, studentID2)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subjectlevel (subjectLvlID INT AUTO_INCREMENT NOT NULL, mark INT NOT NULL, subjectID INT DEFAULT NULL, studentID INT DEFAULT NULL, INDEX IDX_550538D35621423 (subjectID), INDEX IDX_550538D3A3D10F50 (studentID), PRIMARY KEY(subjectLvlID)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(40) NOT NULL, duration VARCHAR(20) NOT NULL, schoolID INT DEFAULT NULL, INDEX schoolID (schoolID), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_response (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, question_list_id_id INT NOT NULL, response_id_id INT NOT NULL, INDEX IDX_DEF6EFFB9D86650F (user_id_id), INDEX IDX_DEF6EFFBC10395DC (question_list_id_id), INDEX IDX_DEF6EFFB6F324507 (response_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE friendship_relation ADD CONSTRAINT FK_D5634873CFF02722 FOREIGN KEY (student_1_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE friendship_relation ADD CONSTRAINT FK_D5634873DD4588CC FOREIGN KEY (student_2_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FD5412041 FOREIGN KEY (id_receiver_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F76110FBA FOREIGN KEY (id_sender_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE qcm ADD CONSTRAINT FK_D7A1FEF469CCBE9A FOREIGN KEY (author_id_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EF675F31B FOREIGN KEY (author_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E9775E708 FOREIGN KEY (theme) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE question_list ADD CONSTRAINT FK_1A2615F74FAF8F53 FOREIGN KEY (question_id_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE question_list ADD CONSTRAINT FK_1A2615F7F16A9A2D FOREIGN KEY (qcm_id_id) REFERENCES qcm (id)');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFB4FAF8F53 FOREIGN KEY (question_id_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113F16A9A2D FOREIGN KEY (qcm_id_id) REFERENCES qcm (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC1139D86650F FOREIGN KEY (user_id_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D432C39171 FOREIGN KEY (organizerID) REFERENCES student (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D45621423 FOREIGN KEY (subjectID) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE sessionparticipants ADD CONSTRAINT FK_D38DDC1B23E953E FOREIGN KEY (sessionID) REFERENCES session (id)');
        $this->addSql('ALTER TABLE sessionparticipants ADD CONSTRAINT FK_D38DDC1BA3D10F50 FOREIGN KEY (studentID) REFERENCES student (id)');
        $this->addSql('ALTER TABLE Sessioncomment ADD CONSTRAINT FK_CF48C76EC0FDBE26 FOREIGN KEY (idSession) REFERENCES session (id)');
        $this->addSql('ALTER TABLE Sessioncomment ADD CONSTRAINT FK_CF48C76EA79AC4C1 FOREIGN KEY (idStudent) REFERENCES student (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33A0A55892 FOREIGN KEY (trainingID) REFERENCES training (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33A0F967B0 FOREIGN KEY (gradeId) REFERENCES grade (id)');
        $this->addSql('ALTER TABLE givenrecompenses ADD CONSTRAINT FK_CDA15877A3D10F50 FOREIGN KEY (studentID) REFERENCES student (id)');
        $this->addSql('ALTER TABLE givenrecompenses ADD CONSTRAINT FK_CDA1587796B83874 FOREIGN KEY (badgeID) REFERENCES badge (id)');
        $this->addSql('ALTER TABLE subject_level ADD CONSTRAINT FK_8B790DCBA3D10F50 FOREIGN KEY (studentID) REFERENCES student (id)');
        $this->addSql('ALTER TABLE subject_level ADD CONSTRAINT FK_8B790DCB5621423 FOREIGN KEY (subjectID) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE liked_profile ADD CONSTRAINT FK_FB4FE945E8146F4C FOREIGN KEY (studentID1) REFERENCES student (id)');
        $this->addSql('ALTER TABLE liked_profile ADD CONSTRAINT FK_FB4FE945711D3EF6 FOREIGN KEY (studentID2) REFERENCES student (id)');
        $this->addSql('ALTER TABLE subjectlevel ADD CONSTRAINT FK_550538D35621423 FOREIGN KEY (subjectID) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE subjectlevel ADD CONSTRAINT FK_550538D3A3D10F50 FOREIGN KEY (studentID) REFERENCES student (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8F70E4D61D FOREIGN KEY (schoolID) REFERENCES school (id)');
        $this->addSql('ALTER TABLE user_response ADD CONSTRAINT FK_DEF6EFFB9D86650F FOREIGN KEY (user_id_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE user_response ADD CONSTRAINT FK_DEF6EFFBC10395DC FOREIGN KEY (question_list_id_id) REFERENCES question_list (id)');
        $this->addSql('ALTER TABLE user_response ADD CONSTRAINT FK_DEF6EFFB6F324507 FOREIGN KEY (response_id_id) REFERENCES response (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE givenrecompenses DROP FOREIGN KEY FK_CDA1587796B83874');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33A0F967B0');
        $this->addSql('ALTER TABLE question_list DROP FOREIGN KEY FK_1A2615F7F16A9A2D');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113F16A9A2D');
        $this->addSql('ALTER TABLE question_list DROP FOREIGN KEY FK_1A2615F74FAF8F53');
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFB4FAF8F53');
        $this->addSql('ALTER TABLE user_response DROP FOREIGN KEY FK_DEF6EFFBC10395DC');
        $this->addSql('ALTER TABLE user_response DROP FOREIGN KEY FK_DEF6EFFB6F324507');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8F70E4D61D');
        $this->addSql('ALTER TABLE sessionparticipants DROP FOREIGN KEY FK_D38DDC1B23E953E');
        $this->addSql('ALTER TABLE Sessioncomment DROP FOREIGN KEY FK_CF48C76EC0FDBE26');
        $this->addSql('ALTER TABLE friendship_relation DROP FOREIGN KEY FK_D5634873CFF02722');
        $this->addSql('ALTER TABLE friendship_relation DROP FOREIGN KEY FK_D5634873DD4588CC');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FD5412041');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F76110FBA');
        $this->addSql('ALTER TABLE qcm DROP FOREIGN KEY FK_D7A1FEF469CCBE9A');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EF675F31B');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC1139D86650F');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D432C39171');
        $this->addSql('ALTER TABLE sessionparticipants DROP FOREIGN KEY FK_D38DDC1BA3D10F50');
        $this->addSql('ALTER TABLE Sessioncomment DROP FOREIGN KEY FK_CF48C76EA79AC4C1');
        $this->addSql('ALTER TABLE givenrecompenses DROP FOREIGN KEY FK_CDA15877A3D10F50');
        $this->addSql('ALTER TABLE subject_level DROP FOREIGN KEY FK_8B790DCBA3D10F50');
        $this->addSql('ALTER TABLE liked_profile DROP FOREIGN KEY FK_FB4FE945E8146F4C');
        $this->addSql('ALTER TABLE liked_profile DROP FOREIGN KEY FK_FB4FE945711D3EF6');
        $this->addSql('ALTER TABLE subjectlevel DROP FOREIGN KEY FK_550538D3A3D10F50');
        $this->addSql('ALTER TABLE user_response DROP FOREIGN KEY FK_DEF6EFFB9D86650F');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D45621423');
        $this->addSql('ALTER TABLE subject_level DROP FOREIGN KEY FK_8B790DCB5621423');
        $this->addSql('ALTER TABLE subjectlevel DROP FOREIGN KEY FK_550538D35621423');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E9775E708');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33A0A55892');
        $this->addSql('DROP TABLE badge');
        $this->addSql('DROP TABLE friendship_relation');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE qcm');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE question_list');
        $this->addSql('DROP TABLE response');
        $this->addSql('DROP TABLE result');
        $this->addSql('DROP TABLE school');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE sessionparticipants');
        $this->addSql('DROP TABLE Sessioncomment');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE givenrecompenses');
        $this->addSql('DROP TABLE subject_level');
        $this->addSql('DROP TABLE liked_profile');
        $this->addSql('DROP TABLE subject');
        $this->addSql('DROP TABLE subjectlevel');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE user_response');
    }
}
