<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210827004006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create prooph PDO Event Store tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE event_streams (
              no BIGSERIAL,
              real_stream_name VARCHAR(150) NOT NULL,
              stream_name CHAR(41) NOT NULL,
              metadata JSONB,
              category VARCHAR(150),
              PRIMARY KEY (no),
              UNIQUE (stream_name)
            );
        ');
        $this->addSql('CREATE INDEX on event_streams (category);');
        $this->addSql('CREATE TABLE projections (
              no BIGSERIAL,
              name VARCHAR(150) NOT NULL,
              position JSONB,
              state JSONB,
              status VARCHAR(28) NOT NULL,
              locked_until CHAR(26),
              PRIMARY KEY (no),
              UNIQUE (name)
            );
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE event_streams');
        $this->addSql('DROP TABLE projections');
    }
}
