<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260810121144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE complement_adresse complement_adresse VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE vente DROP INDEX UNIQ_888A2A4C19EB6921, ADD INDEX IDX_888A2A4C19EB6921 (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE complement_adresse complement_adresse VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE vente DROP INDEX IDX_888A2A4C19EB6921, ADD UNIQUE INDEX UNIQ_888A2A4C19EB6921 (client_id)');
    }
}
