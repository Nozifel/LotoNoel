<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200918070100 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tirage (id INT AUTO_INCREMENT NOT NULL, loto_id INT NOT NULL, nombre INT NOT NULL, est_tirer TINYINT(1) NOT NULL, date_tirage DATE DEFAULT NULL, INDEX IDX_2A145AFFDECFF918 (loto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tirage ADD CONSTRAINT FK_2A145AFFDECFF918 FOREIGN KEY (loto_id) REFERENCES loto (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tirage');
    }
}
