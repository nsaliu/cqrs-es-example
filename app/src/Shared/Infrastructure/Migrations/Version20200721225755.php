<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200721225755 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(<<<'SQL'
CREATE TABLE projection_users
(
	uuid VARCHAR(255) NOT NULL,
	name VARCHAR(255) NOT NULL,
	surname VARCHAR(255) NOT NULL,
	address_1_uuid VARCHAR(255) NULL,
	address_1_street_name VARCHAR(255) NULL,
	address_1_street_number INT NULL,
	address_2_uuid VARCHAR(255) NULL,
	address_2_street_name VARCHAR(255) NULL,
	address_2_street_number INT NULl,
	created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)'
);

CREATE UNIQUE index projection_users_uuid_uindex
	ON projection_users (uuid);

ALTER TABLE projection_users
	ADD CONSTRAINT projection_users_pk
		PRIMARY KEY (uuid);
SQL
);
    }

    public function down(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(<<<'SQL'
DROP TABLE IF EXISTS projection_users;
SQL
);
    }
}
