<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250519143637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment CHANGE treatment_description treatment_description LONGTEXT NOT NULL, CHANGE notes notes LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE appointment RENAME INDEX patient_id TO IDX_FE38F8446B899279');
        $this->addSql('ALTER TABLE appointment RENAME INDEX doctor_id TO IDX_FE38F84487F4FB17');
        $this->addSql('ALTER TABLE doctor RENAME INDEX user_id TO UNIQ_1FC0F36AA76ED395');
        $this->addSql('ALTER TABLE invoice DROP INDEX appointment_id, ADD UNIQUE INDEX UNIQ_90651744E5B533F9 (appointment_id)');
        $this->addSql('ALTER TABLE patient RENAME INDEX user_id TO UNIQ_1ADAD7EBA76ED395');
        $this->addSql('ALTER TABLE receptionist RENAME INDEX user_id TO UNIQ_F168ACCFA76ED395');
        $this->addSql('DROP INDEX dni ON user');
        $this->addSql('ALTER TABLE user_role RENAME INDEX user_id TO IDX_2DE8C6A3A76ED395');
        $this->addSql('ALTER TABLE user_role RENAME INDEX role_id TO IDX_2DE8C6A3D60322AC');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient RENAME INDEX uniq_1adad7eba76ed395 TO user_id');
        $this->addSql('ALTER TABLE user_role RENAME INDEX idx_2de8c6a3a76ed395 TO user_id');
        $this->addSql('ALTER TABLE user_role RENAME INDEX idx_2de8c6a3d60322ac TO role_id');
        $this->addSql('ALTER TABLE appointment CHANGE treatment_description treatment_description TEXT NOT NULL, CHANGE notes notes TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE appointment RENAME INDEX idx_fe38f84487f4fb17 TO doctor_id');
        $this->addSql('ALTER TABLE appointment RENAME INDEX idx_fe38f8446b899279 TO patient_id');
        $this->addSql('ALTER TABLE invoice DROP INDEX UNIQ_90651744E5B533F9, ADD INDEX appointment_id (appointment_id)');
        $this->addSql('CREATE UNIQUE INDEX dni ON user (dni)');
        $this->addSql('ALTER TABLE receptionist RENAME INDEX uniq_f168accfa76ed395 TO user_id');
        $this->addSql('ALTER TABLE doctor RENAME INDEX uniq_1fc0f36aa76ed395 TO user_id');
    }
}
