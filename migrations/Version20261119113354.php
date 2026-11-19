<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261119113354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout de la colonne name à status et insertion des statuts Actif, Disponible et Maintenance';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE status ADD name VARCHAR(255) NOT NULL');
        $this->addSql(<<<'SQL'
            INSERT INTO status (name) VALUES
                ('Actif'),
                ('Disponible'),
                ('Maintenance')
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            DELETE FROM status WHERE name IN ('Actif', 'Disponible', 'Maintenance')
        SQL);
        $this->addSql('ALTER TABLE status DROP name');
    }
}