<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261019132311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE unite ADD reservation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE unite ADD CONSTRAINT FK_1D64C118B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('CREATE INDEX IDX_1D64C118B83297E7 ON unite (reservation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE unite DROP FOREIGN KEY FK_1D64C118B83297E7');
        $this->addSql('DROP INDEX IDX_1D64C118B83297E7 ON unite');
        $this->addSql('ALTER TABLE unite DROP reservation_id');
    }
}
