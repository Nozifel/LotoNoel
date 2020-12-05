<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201205130537 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tirage ADD combinaison_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tirage ADD CONSTRAINT FK_2A145AFFD9D0413F FOREIGN KEY (combinaison_id) REFERENCES combinaison (id)');
        $this->addSql('CREATE INDEX IDX_2A145AFFD9D0413F ON tirage (combinaison_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tirage DROP FOREIGN KEY FK_2A145AFFD9D0413F');
        $this->addSql('DROP INDEX IDX_2A145AFFD9D0413F ON tirage');
        $this->addSql('ALTER TABLE tirage DROP combinaison_id');
    }
}
