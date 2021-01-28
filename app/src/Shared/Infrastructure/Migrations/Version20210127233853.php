<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210127233853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds the Shared projection_comments table';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(<<<SQL
CREATE TABLE projection_comments
(
    uuid         VARCHAR(36) NOT NULL COMMENT '(DC2Type:comment_uuid)',
    author_uuid  VARCHAR(36) NOT NULL COMMENT '(DC2Type:author_uuid)',
    article_uuid VARCHAR(36) NOT NULL COMMENT '(DC2Type:article_uuid)',
    body         LONGTEXT    NOT NULL,
    created_at   DATE        NOT NULL COMMENT '(DC2Type:date_immutable)',
    UNIQUE INDEX uuid_unq (uuid),
    PRIMARY KEY (uuid, author_uuid, article_uuid)
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

        $this->addSql(<<<SQL
DROP TABLE projection_comments
SQL
        );
    }
}
