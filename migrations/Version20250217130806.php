<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250217130806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, score INT NOT NULL, date_creation DATETIME NOT NULL, chef VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitude (id INT AUTO_INCREMENT NOT NULL, texte VARCHAR(255) NOT NULL, difficulte VARCHAR(15) NOT NULL, couleur VARCHAR(7) NOT NULL, periodicite VARCHAR(15) NOT NULL, cible VARCHAR(15) NOT NULL, date_creation DATETIME NOT NULL, createur VARCHAR(255) NOT NULL, groupe VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique_score (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, habitude_id INT DEFAULT NULL, points INT NOT NULL, date_action DATETIME NOT NULL, action VARCHAR(15) NOT NULL, INDEX IDX_7C19ED22FB88E14F (utilisateur_id), INDEX IDX_7C19ED22B80619B9 (habitude_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invitation (id INT AUTO_INCREMENT NOT NULL, emetteur_id INT DEFAULT NULL, recepetur_id INT DEFAULT NULL, groupe_id INT DEFAULT NULL, statut VARCHAR(15) NOT NULL, date_envoi DATETIME NOT NULL, INDEX IDX_F11D61A279E92E8C (emetteur_id), INDEX IDX_F11D61A2326A3E69 (recepetur_id), INDEX IDX_F11D61A27A45358C (groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, message VARCHAR(255) NOT NULL, date_envoi DATETIME NOT NULL, statut VARCHAR(10) NOT NULL, INDEX IDX_BF5476CAFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, motdepase VARCHAR(255) NOT NULL, string VARCHAR(255) DEFAULT NULL, last_login DATETIME NOT NULL, groupe VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historique_score ADD CONSTRAINT FK_7C19ED22FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE historique_score ADD CONSTRAINT FK_7C19ED22B80619B9 FOREIGN KEY (habitude_id) REFERENCES habitude (id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A279E92E8C FOREIGN KEY (emetteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A2326A3E69 FOREIGN KEY (recepetur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A27A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique_score DROP FOREIGN KEY FK_7C19ED22FB88E14F');
        $this->addSql('ALTER TABLE historique_score DROP FOREIGN KEY FK_7C19ED22B80619B9');
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A279E92E8C');
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A2326A3E69');
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A27A45358C');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAFB88E14F');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE habitude');
        $this->addSql('DROP TABLE historique_score');
        $this->addSql('DROP TABLE invitation');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
