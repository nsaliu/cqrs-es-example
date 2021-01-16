<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Doctrine\Exception;

use App\Article\Domain\ArticleUuid;
use Exception;

final class ArticleNotFoundByUuidException extends Exception
{
    public function __construct(ArticleUuid $articleUuid)
    {
        parent::__construct(
            sprintf(
                'Article with uuid %s not found',
                $articleUuid->toString()
            ),
            0,
            null
        );
    }
}
