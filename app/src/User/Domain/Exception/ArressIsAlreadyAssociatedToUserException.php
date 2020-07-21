<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

use App\User\Domain\Address\AddressUuid;
use Exception;

final class ArressIsAlreadyAssociatedToUserException extends Exception
{
    public function __construct(AddressUuid $addressUuid)
    {
        parent::__construct(
            sprintf(
                'Given address uuid %s is already associated to user',
                $addressUuid->toString()
            ),
            0,
            null
        );
    }
}
