<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261119101410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE unite ADD status_id INT NOT NULL, DROP statut');
        $this->addSql('ALTER TABLE unite ADD CONSTRAINT FK_1D64C1186BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_1D64C1186BF700BD ON unite (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE status');
        $this->addSql('ALTER TABLE unite DROP FOREIGN KEY FK_1D64C1186BF700BD');
        $this->addSql('DROP INDEX IDX_1D64C1186BF700BD ON unite');
        $this->addSql('ALTER TABLE unite ADD statut VARCHAR(255) NOT NULL, DROP status_id');
    }
}
