<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230122192832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (idaddress INT AUTO_INCREMENT NOT NULL, client INT DEFAULT NULL, pays VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, codepostal VARCHAR(255) NOT NULL, voie VARCHAR(255) NOT NULL, rue VARCHAR(255) NOT NULL, appt VARCHAR(255) DEFAULT NULL, batiment VARCHAR(255) DEFAULT NULL, INDEX IDX_D4E6F81C7440455 (client), PRIMARY KEY(idaddress)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (idclient INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(idclient)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE numero (idnum INT AUTO_INCREMENT NOT NULL, client INT DEFAULT NULL, codepays VARCHAR(255) NOT NULL, numero VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F55AE19EC7440455 (client), PRIMARY KEY(idnum)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81C7440455 FOREIGN KEY (client) REFERENCES client (idclient)');
        $this->addSql('ALTER TABLE numero ADD CONSTRAINT FK_F55AE19EC7440455 FOREIGN KEY (client) REFERENCES client (idclient)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81C7440455');
        $this->addSql('ALTER TABLE numero DROP FOREIGN KEY FK_F55AE19EC7440455');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE numero');
    }
}
