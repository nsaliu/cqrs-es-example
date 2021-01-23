<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210123003430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds the Shared projection_articles table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE TABLE projection_articles
(
    uuid           VARCHAR(36)  NOT NULL COMMENT '(DC2Type:article_uuid)',
    author_uuid    VARCHAR(36)  NOT NULL COMMENT '(DC2Type:author_uuid)',
    author_name    VARCHAR(255) NOT NULL,
    author_surname VARCHAR(255) NOT NULL,
    title          VARCHAR(255) NOT NULL,
    text           LONGTEXT     NOT NULL,
    created_at     DATE         NOT NULL COMMENT '(DC2Type:date_immutable)',
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
        $this->addSql(<<<SQL
DROP TABLE projection_articles;
SQL
        );
    }
}
