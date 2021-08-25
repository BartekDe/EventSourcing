<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210825194324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE partner (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(64) NOT NULL, description VARCHAR(255) NOT NULL, nip VARCHAR(10) NOT NULL, webpage VARCHAR(255) DEFAULT NULL, creation_time DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE partner');
    }
}
