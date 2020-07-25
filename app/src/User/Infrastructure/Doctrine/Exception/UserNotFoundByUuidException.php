<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Exception;

use App\User\Domain\UserUuid;
use Exception;

final class UserNotFoundByUuidException extends Exception
{
    public function __construct(UserUuid $userUuid)
    {
        parent::__construct(
            sprintf(
                'User with uuid %s not found',
                $userUuid->toString()
            ),
            0,
            null
        );
    }
}
