<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210826185206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__partner AS SELECT id, name, description, nip, webpage, creation_time FROM partner');
        $this->addSql('DROP TABLE partner');
        $this->addSql('CREATE TABLE partner (uuid CHAR(36) NOT NULL --(DC2Type:uuid)
        , name VARCHAR(64) NOT NULL COLLATE BINARY, description VARCHAR(255) NOT NULL COLLATE BINARY, nip VARCHAR(10) NOT NULL COLLATE BINARY, webpage VARCHAR(255) DEFAULT NULL COLLATE BINARY, creation_time DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , PRIMARY KEY(uuid))');
        $this->addSql('INSERT INTO partner (uuid, name, description, nip, webpage, creation_time) SELECT id, name, description, nip, webpage, creation_time FROM __temp__partner');
        $this->addSql('DROP TABLE __temp__partner');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__partner AS SELECT uuid, name, description, nip, webpage, creation_time FROM partner');
        $this->addSql('DROP TABLE partner');
        $this->addSql('CREATE TABLE partner (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(64) NOT NULL, description VARCHAR(255) NOT NULL, nip VARCHAR(10) NOT NULL, webpage VARCHAR(255) DEFAULT NULL, creation_time DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO partner (id, name, description, nip, webpage, creation_time) SELECT uuid, name, description, nip, webpage, creation_time FROM __temp__partner');
        $this->addSql('DROP TABLE __temp__partner');
    }
}
