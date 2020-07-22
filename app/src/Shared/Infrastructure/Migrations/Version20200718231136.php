<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200718231136 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(<<<'SQL'
DROP TABLE IF EXISTS `users`;
SQL
);

        $this->addSql(<<<'SQL'
CREATE TABLE `events` (
  `event_id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:guid)',
  `event_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `aggregate_root_id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:guid)',
  `aggregate_root_version` int(11) NOT NULL,
  `time_of_recording` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:json_array)',
  PRIMARY KEY (`event_id`),
  UNIQUE KEY `UNIQ_5387574A745C37BA70670451` (`aggregate_root_id`,`aggregate_root_version`),
  KEY `IDX_5387574A745C37BA` (`aggregate_root_id`),
  KEY `IDX_5387574A553FE28D` (`time_of_recording`),
  KEY `IDX_5387574A745C37BA70670451` (`aggregate_root_id`,`aggregate_root_version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
SQL
);
    }

    public function down(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(<<<'SQL'
CREATE TABLE `users` (
    uuid    CHAR(36) NOT NULL COMMENT '(DC2Type:user_uuid)',
    name    VARCHAR(255) NOT NULL,
    surname VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    UNIQUE INDEX uuid_unq (uuid),
    PRIMARY KEY (uuid)
) DEFAULT CHARACTER SET utf8mb4
  COLLATE `utf8mb4_unicode_ci`
  ENGINE = InnoDB;
SQL
        );

        $this->addSql(<<<'SQL'
DROP TABLE IF EXISTS `events`;
SQL
);
    }
}
