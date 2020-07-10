<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

use Exception;
use Throwable;

final class UserNamePropertyIsTooShort extends Exception
{
    public function __construct()
    {
        parent::__construct(
            'The name of the User must have a length greater than zero',
            0,
            null
        );
    }
}
