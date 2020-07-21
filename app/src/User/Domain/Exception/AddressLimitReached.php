<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

use Exception;

final class AddressLimitReached extends Exception
{
    public function __construct()
    {
        parent::__construct(
            'Cannot add more addresses to user because the limit is two',
            0,
            null
        );
    }
}
