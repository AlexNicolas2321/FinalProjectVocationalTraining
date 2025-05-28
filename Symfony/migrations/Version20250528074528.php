<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250528074528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice ADD tax_rate NUMERIC(5, 2) NOT NULL, ADD tax_amount NUMERIC(10, 2) NOT NULL, ADD total_amount NUMERIC(10, 2) NOT NULL, ADD pdf_file_path VARCHAR(255) DEFAULT NULL, CHANGE amount base_amount NUMERIC(10, 2) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice ADD amount NUMERIC(10, 2) NOT NULL, DROP base_amount, DROP tax_rate, DROP tax_amount, DROP total_amount, DROP pdf_file_path');
    }
}
