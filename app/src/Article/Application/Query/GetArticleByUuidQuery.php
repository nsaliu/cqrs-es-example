<?php

declare(strict_types=1);

namespace App\Article\Application\Query;

use App\Article\Domain\ArticleUuid;

final class GetArticleByUuidQuery
{
    private ArticleUuid $articleUuid;

    public function __construct(
        ArticleUuid $articleUuid
    ) {
        $this->articleUuid = $articleUuid;
    }

    public function getArticleUuid(): ArticleUuid
    {
        return $this->articleUuid;
    }
}
