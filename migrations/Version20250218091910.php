<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250218091910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur ADD groupe_id INT DEFAULT NULL, ADD mot_de_passe VARCHAR(255) NOT NULL, DROP motdepase, DROP groupe, CHANGE last_login last_login DATETIME DEFAULT NULL, CHANGE string profile_picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B37A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B386CC499D ON utilisateur (pseudo)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur (email)');
        $this->addSql('CREATE INDEX IDX_1D1C63B37A45358C ON utilisateur (groupe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B37A45358C');
        $this->addSql('DROP INDEX UNIQ_1D1C63B386CC499D ON utilisateur');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur');
        $this->addSql('DROP INDEX IDX_1D1C63B37A45358C ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD groupe VARCHAR(255) NOT NULL, DROP groupe_id, CHANGE last_login last_login DATETIME NOT NULL, CHANGE mot_de_passe motdepase VARCHAR(255) NOT NULL, CHANGE profile_picture string VARCHAR(255) DEFAULT NULL');
    }
}
