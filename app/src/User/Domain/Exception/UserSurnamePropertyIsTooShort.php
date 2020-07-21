<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

use Exception;

final class UserSurnamePropertyIsTooShort extends Exception
{
    public function __construct()
    {
        parent::__construct(
            'The surname of the User must have a length greater than zero',
            0,
            null
        );
    }
}
