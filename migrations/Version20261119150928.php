<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261119150928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

public function up(Schema $schema): void
    {
        // Les colonnes paid_at et period ainsi que la FK FK_1D64C1186BF700BD sont déjà présentes en base
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_1D64C1186BF700BD ON unite (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP paid_at, DROP period');
        $this->addSql('ALTER TABLE unite DROP FOREIGN KEY FK_1D64C1186BF700BD');
        $this->addSql('DROP INDEX IDX_1D64C1186BF700BD ON unite');
    }
}
