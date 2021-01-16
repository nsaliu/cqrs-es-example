<?php

declare(strict_types=1);

namespace App\Article\Domain\Repository;

use App\Article\Domain\Article;
use App\Article\Domain\ArticleUuid;

interface ArticleRepositoryInterface
{
    public function save(Article $article): void;

    public function get(ArticleUuid $userUuid): Article;
}
