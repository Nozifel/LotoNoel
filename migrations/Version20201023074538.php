<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201023074538 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE grille (id INT AUTO_INCREMENT NOT NULL, loto_id INT DEFAULT NULL, joueur_id INT NOT NULL, grille JSON DEFAULT NULL, complete DATETIME DEFAULT NULL, INDEX IDX_D452165FDECFF918 (loto_id), INDEX IDX_D452165FA9E2D76C (joueur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE grille ADD CONSTRAINT FK_D452165FDECFF918 FOREIGN KEY (loto_id) REFERENCES loto (id)');
        $this->addSql('ALTER TABLE grille ADD CONSTRAINT FK_D452165FA9E2D76C FOREIGN KEY (joueur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tirage ADD joueur_id INT DEFAULT NULL, DROP est_tirer');
        $this->addSql('ALTER TABLE tirage ADD CONSTRAINT FK_2A145AFFA9E2D76C FOREIGN KEY (joueur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2A145AFFA9E2D76C ON tirage (joueur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE grille');
        $this->addSql('ALTER TABLE tirage DROP FOREIGN KEY FK_2A145AFFA9E2D76C');
        $this->addSql('DROP INDEX IDX_2A145AFFA9E2D76C ON tirage');
        $this->addSql('ALTER TABLE tirage ADD est_tirer TINYINT(1) NOT NULL, DROP joueur_id');
    }
}
