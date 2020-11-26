<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200923100050 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE combinaison (id INT AUTO_INCREMENT NOT NULL, gagnant_id INT DEFAULT NULL, loto_id INT NOT NULL, pattern JSON DEFAULT NULL, special VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_6DCBB34B2F942B8 (gagnant_id), INDEX IDX_6DCBB34BDECFF918 (loto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE combinaison ADD CONSTRAINT FK_6DCBB34B2F942B8 FOREIGN KEY (gagnant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE combinaison ADD CONSTRAINT FK_6DCBB34BDECFF918 FOREIGN KEY (loto_id) REFERENCES loto (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE combinaison');
    }
}
