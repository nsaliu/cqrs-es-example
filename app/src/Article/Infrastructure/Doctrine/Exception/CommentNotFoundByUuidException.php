<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Doctrine\Exception;

use App\Article\Domain\CommentUuid;
use Exception;

final class CommentNotFoundByUuidException extends Exception
{
    public function __construct(CommentUuid $articleUuid)
    {
        parent::__construct(
            sprintf(
                'Comment with uuid %s not found',
                $articleUuid->toString()
            ),
            0,
            null
        );
    }
}
