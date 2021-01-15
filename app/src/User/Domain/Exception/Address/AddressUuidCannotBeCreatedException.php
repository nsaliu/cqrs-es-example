<?php

declare(strict_types=1);

namespace App\User\Domain\Exception\Address;

use Exception;

final class AddressUuidCannotBeCreatedException extends Exception
{
    public function __construct(string $userUuid)
    {
        parent::__construct(
            sprintf(
                'Address uuid can not be created due to invalid UUID string representation: %s',
                $userUuid
            ),
            0,
            null
        );
    }
}
