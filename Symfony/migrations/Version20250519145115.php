<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250519145115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1FC0F36A444F97DD ON doctor (phone)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1ADAD7EB444F97DD ON patient (phone)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F168ACCF444F97DD ON receptionist (phone)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_1ADAD7EB444F97DD ON patient');
        $this->addSql('DROP INDEX UNIQ_1FC0F36A444F97DD ON doctor');
        $this->addSql('DROP INDEX UNIQ_F168ACCF444F97DD ON receptionist');
    }
}
