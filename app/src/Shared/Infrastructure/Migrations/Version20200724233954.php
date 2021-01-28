<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200724233954 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            <<<SQL
CREATE TABLE projection_users
(
    uuid                    VARCHAR(36)  NOT NULL COMMENT '(DC2Type:user_uuid)',
    name                    VARCHAR(255) NOT NULL,
    surname                 VARCHAR(255) NOT NULL,
    address_1_uuid          VARCHAR(36)  DEFAULT NULL COMMENT '(DC2Type:address_uuid)',
    address_1_street_name   VARCHAR(255) DEFAULT NULL,
    address_1_street_number INT          DEFAULT NULL,
    address_2_uuid          VARCHAR(36)  DEFAULT NULL COMMENT '(DC2Type:address_uuid)',
    address_2_street_name   VARCHAR(255) DEFAULT NULL,
    address_2_street_number INT          DEFAULT NULL,
    created_at              DATETIME     NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    updated_at              DATETIME     NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    UNIQUE INDEX uuid_unq (uuid),
    PRIMARY KEY (uuid)
) DEFAULT CHARACTER SET utf8mb4
  COLLATE `utf8mb4_unicode_ci`
  ENGINE = InnoDB
SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            <<<SQL
DROP TABLE projection_users
SQL
        );
    }
}
