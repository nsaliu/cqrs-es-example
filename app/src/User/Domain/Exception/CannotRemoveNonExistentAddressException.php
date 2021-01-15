<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

use App\User\Domain\Address\AddressUuid;
use Exception;

final class CannotRemoveNonExistentAddressException extends Exception
{
    public function __construct(AddressUuid $addressUserUuid)
    {
        parent::__construct(
            sprintf(
                'Given addresses uuid %s was not found in user addresses collection and can not be removed',
                $addressUserUuid->toString()
            ),
            0,
            null
        );
    }
}
