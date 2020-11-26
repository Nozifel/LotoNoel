<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200918114806 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loto ADD auteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE loto ADD CONSTRAINT FK_8561DB8160BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8561DB8160BB6FE6 ON loto (auteur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loto DROP FOREIGN KEY FK_8561DB8160BB6FE6');
        $this->addSql('DROP INDEX IDX_8561DB8160BB6FE6 ON loto');
        $this->addSql('ALTER TABLE loto DROP auteur_id');
    }
}
