<?php

declare(strict_types=1);

namespace App\Article\Domain\Exception;

use Exception;

final class AuthorUuidCannotBeCreatedException extends Exception
{
    public function __construct(string $userUuid)
    {
        parent::__construct(
            sprintf(
                'Author uuid can not be created due to invalid UUID string representation: %s',
                $userUuid
            ),
            0,
            null
        );
    }
}
