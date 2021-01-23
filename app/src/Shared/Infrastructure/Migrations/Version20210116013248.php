<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210116013248 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(<<<SQL
CREATE TABLE projection_articles
(
    uuid        VARCHAR(36)  NOT NULL COMMENT '(DC2Type:article_uuid)',
    author_uuid VARCHAR(36)  NOT NULL COMMENT '(DC2Type:author_uuid)',
    title       VARCHAR(255) NOT NULL,
    text        LONGTEXT     NOT NULL,
    created_at  DATE         NOT NULL COMMENT '(DC2Type:date_immutable)',
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
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE projection_articles');
    }
}
