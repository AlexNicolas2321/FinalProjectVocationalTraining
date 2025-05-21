<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250521140237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment ADD treatment_id INT NOT NULL');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id)');
        $this->addSql('CREATE INDEX IDX_FE38F844471C0366 ON appointment (treatment_id)');
        $this->addSql('ALTER TABLE treatment DROP FOREIGN KEY FK_98013C31E5B533F9');
        $this->addSql('DROP INDEX UNIQ_98013C31E5B533F9 ON treatment');
        $this->addSql('ALTER TABLE treatment DROP appointment_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE treatment ADD appointment_id INT NOT NULL');
        $this->addSql('ALTER TABLE treatment ADD CONSTRAINT FK_98013C31E5B533F9 FOREIGN KEY (appointment_id) REFERENCES appointment (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98013C31E5B533F9 ON treatment (appointment_id)');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844471C0366');
        $this->addSql('DROP INDEX IDX_FE38F844471C0366 ON appointment');
        $this->addSql('ALTER TABLE appointment DROP treatment_id');
    }
}
