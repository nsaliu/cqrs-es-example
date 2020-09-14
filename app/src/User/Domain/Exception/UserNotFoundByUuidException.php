<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

use App\User\Domain\UserId;
use Exception;

final class UserNotFoundByUuidException extends Exception
{
    public function __construct(UserId $userId)
    {
        parent::__construct(
            sprintf(
                'User not found with uuid %s',
                $userId->toString()
            ),
            0,
            null
        );
    }
}
