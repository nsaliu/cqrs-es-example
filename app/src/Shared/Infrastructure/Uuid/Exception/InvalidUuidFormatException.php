<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Uuid\Exception;

use Exception;

final class InvalidUuidFormatException extends Exception
{
    public function __construct(string $uuid)
    {
        parent::__construct(
            sprintf(
                'Given uuid %s is not in valid format and an instance of Uuid cannot be created.',
                $uuid
            ),
            0,
            null
        );
    }
}
