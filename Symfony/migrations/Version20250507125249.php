<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250507125249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Appointment (id INT AUTO_INCREMENT NOT NULL, date_time DATETIME NOT NULL, deleted TINYINT(1) NOT NULL, lead_patient_id INT NOT NULL, doctor_id INT NOT NULL, treatment_id INT NOT NULL, INDEX IDX_78A47793431289E5 (lead_patient_id), INDEX IDX_78A4779387F4FB17 (doctor_id), INDEX IDX_78A47793471C0366 (treatment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE Doctor (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, speciality_id INT NOT NULL, INDEX IDX_186CF65C3B5A08D7 (speciality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE Invoice (id INT AUTO_INCREMENT NOT NULL, issued_at DATETIME NOT NULL, total NUMERIC(10, 2) NOT NULL, appointment_id INT NOT NULL, UNIQUE INDEX UNIQ_5FD82ED8E5B533F9 (appointment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE LeadPatient (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, dni VARCHAR(9) NOT NULL, phone VARCHAR(20) DEFAULT NULL, email VARCHAR(150) NOT NULL, birth_date DATE NOT NULL, is_lead TINYINT(1) NOT NULL, submitted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE Role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE Speciality (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE Treatment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE TreatmentPlan (id INT AUTO_INCREMENT NOT NULL, notes LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, appointment_id INT NOT NULL, lead_patient_id INT NOT NULL, dentist_id INT NOT NULL, treatment_id INT NOT NULL, INDEX IDX_4C3F16B1E5B533F9 (appointment_id), INDEX IDX_4C3F16B1431289E5 (lead_patient_id), INDEX IDX_4C3F16B11CE0A142 (dentist_id), INDEX IDX_4C3F16B1471C0366 (treatment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE receptionists (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, phone VARCHAR(20) DEFAULT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_10247886A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, dni VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, role_id INT DEFAULT NULL, INDEX IDX_1483A5E9D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE Appointment ADD CONSTRAINT FK_78A47793431289E5 FOREIGN KEY (lead_patient_id) REFERENCES LeadPatient (id)');
        $this->addSql('ALTER TABLE Appointment ADD CONSTRAINT FK_78A4779387F4FB17 FOREIGN KEY (doctor_id) REFERENCES Doctor (id)');
        $this->addSql('ALTER TABLE Appointment ADD CONSTRAINT FK_78A47793471C0366 FOREIGN KEY (treatment_id) REFERENCES Treatment (id)');
        $this->addSql('ALTER TABLE Doctor ADD CONSTRAINT FK_186CF65C3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES Speciality (id)');
        $this->addSql('ALTER TABLE Invoice ADD CONSTRAINT FK_5FD82ED8E5B533F9 FOREIGN KEY (appointment_id) REFERENCES Appointment (id)');
        $this->addSql('ALTER TABLE TreatmentPlan ADD CONSTRAINT FK_4C3F16B1E5B533F9 FOREIGN KEY (appointment_id) REFERENCES Appointment (id)');
        $this->addSql('ALTER TABLE TreatmentPlan ADD CONSTRAINT FK_4C3F16B1431289E5 FOREIGN KEY (lead_patient_id) REFERENCES LeadPatient (id)');
        $this->addSql('ALTER TABLE TreatmentPlan ADD CONSTRAINT FK_4C3F16B11CE0A142 FOREIGN KEY (dentist_id) REFERENCES Doctor (id)');
        $this->addSql('ALTER TABLE TreatmentPlan ADD CONSTRAINT FK_4C3F16B1471C0366 FOREIGN KEY (treatment_id) REFERENCES Treatment (id)');
        $this->addSql('ALTER TABLE receptionists ADD CONSTRAINT FK_10247886A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9D60322AC FOREIGN KEY (role_id) REFERENCES Role (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Appointment DROP FOREIGN KEY FK_78A47793431289E5');
        $this->addSql('ALTER TABLE Appointment DROP FOREIGN KEY FK_78A4779387F4FB17');
        $this->addSql('ALTER TABLE Appointment DROP FOREIGN KEY FK_78A47793471C0366');
        $this->addSql('ALTER TABLE Doctor DROP FOREIGN KEY FK_186CF65C3B5A08D7');
        $this->addSql('ALTER TABLE Invoice DROP FOREIGN KEY FK_5FD82ED8E5B533F9');
        $this->addSql('ALTER TABLE TreatmentPlan DROP FOREIGN KEY FK_4C3F16B1E5B533F9');
        $this->addSql('ALTER TABLE TreatmentPlan DROP FOREIGN KEY FK_4C3F16B1431289E5');
        $this->addSql('ALTER TABLE TreatmentPlan DROP FOREIGN KEY FK_4C3F16B11CE0A142');
        $this->addSql('ALTER TABLE TreatmentPlan DROP FOREIGN KEY FK_4C3F16B1471C0366');
        $this->addSql('ALTER TABLE receptionists DROP FOREIGN KEY FK_10247886A76ED395');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9D60322AC');
        $this->addSql('DROP TABLE Appointment');
        $this->addSql('DROP TABLE Doctor');
        $this->addSql('DROP TABLE Invoice');
        $this->addSql('DROP TABLE LeadPatient');
        $this->addSql('DROP TABLE Role');
        $this->addSql('DROP TABLE Speciality');
        $this->addSql('DROP TABLE Treatment');
        $this->addSql('DROP TABLE TreatmentPlan');
        $this->addSql('DROP TABLE receptionists');
        $this->addSql('DROP TABLE users');
    }
}
