<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

use Exception;

final class UserUuidCannotBeCreatedException extends Exception
{
    public function __construct($uuid)
    {
        parent::__construct(
            sprintf(
                'User uuid can not be created due to invalid UUID string representation: %s',
                $uuid
            ),
            0,
            null
        );
    }
}
