<?php

declare(strict_types=1);

namespace App\User\Domain\Exception\Address;

use Exception;

final class AddressStreetNameIsInvalidException extends Exception
{
    public function __construct(string $streetName)
    {
        parent::__construct(
            sprintf(
                'Given street name "%s" is invalid',
                $streetName
            ),
            0,
            null
        );
    }
}
