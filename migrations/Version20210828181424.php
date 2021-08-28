<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210828181424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE partner ADD COLUMN version INTEGER NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE partner DROP COLUMN version');
    }
}
