<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200915064921 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE loto (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, hauteur_grille INT NOT NULL, largeur_ille INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE loto_user (loto_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A284CCF1DECFF918 (loto_id), INDEX IDX_A284CCF1A76ED395 (user_id), PRIMARY KEY(loto_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE loto_user ADD CONSTRAINT FK_A284CCF1DECFF918 FOREIGN KEY (loto_id) REFERENCES loto (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE loto_user ADD CONSTRAINT FK_A284CCF1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loto_user DROP FOREIGN KEY FK_A284CCF1DECFF918');
        $this->addSql('DROP TABLE loto');
        $this->addSql('DROP TABLE loto_user');
    }
}
