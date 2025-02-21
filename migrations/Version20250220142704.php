<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250220142704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe CHANGE membres membres LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE habitude ADD date_echeance DATETIME DEFAULT NULL, ADD est_completee TINYINT(1) NOT NULL, CHANGE createur_id createur_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe CHANGE membres membres VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE habitude DROP date_echeance, DROP est_completee, CHANGE createur_id createur_id INT DEFAULT NULL');
    }
}
