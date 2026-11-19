<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261119091137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création de la table type, mise à jour de unite et insertion des types de serveurs';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, Name VARCHAR(255) NOT NULL, Color VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql(<<<'SQL'
            INSERT INTO type (Name, Color) VALUES
                ('Serveur de base de données', '#EF4444'),
                ('Serveur de stockage / sauvegarde', '#F97316'),
                ('Serveur de calcul / IA (GPU)', '#EAB308'),
                ('Serveur web / applicatif', '#22C55E'),
                ('Serveur de virtualisation', '#3B82F6'),
                ('Serveur de messagerie / collaboration', '#8B5CF6')
        SQL);
        $this->addSql('ALTER TABLE unite ADD type_id INT DEFAULT NULL, DROP type, DROP couleur');
        $this->addSql('ALTER TABLE unite ADD CONSTRAINT FK_1D64C118C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_1D64C118C54C8C93 ON unite (type_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE unite DROP FOREIGN KEY FK_1D64C118C54C8C93');
        $this->addSql('DROP INDEX IDX_1D64C118C54C8C93 ON unite');
        $this->addSql('ALTER TABLE unite ADD type VARCHAR(255) NOT NULL, ADD couleur VARCHAR(255) NOT NULL, DROP type_id');
        $this->addSql(<<<'SQL'
            DELETE FROM type WHERE name IN (
                'Serveur de base de données',
                'Serveur de stockage / sauvegarde',
                'Serveur de calcul / IA (GPU)',
                'Serveur web / applicatif',
                'Serveur de virtualisation',
                'Serveur de messagerie / collaboration'
            )
        SQL);
        $this->addSql('DROP TABLE type');
    }
}