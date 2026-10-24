<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261020141128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clients ADD utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE clients ADD CONSTRAINT FK_C82E74FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C82E74FB88E14F ON clients (utilisateur_id)');
        $this->addSql('ALTER TABLE utilisateur ADD tel VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clients DROP FOREIGN KEY FK_C82E74FB88E14F');
        $this->addSql('DROP INDEX UNIQ_C82E74FB88E14F ON clients');
        $this->addSql('ALTER TABLE clients DROP utilisateur_id');
        $this->addSql('ALTER TABLE utilisateur DROP tel');
    }
}
