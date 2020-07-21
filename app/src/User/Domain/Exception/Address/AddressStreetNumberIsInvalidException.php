<?php

declare(strict_types=1);

namespace App\User\Domain\Exception\Address;

use Exception;

final class AddressStreetNumberIsInvalidException extends Exception
{
    public function __construct(int $streetNumber)
    {
        parent::__construct(
            sprintf(
                'Given street streetNumber "%d" is invalid',
                $streetNumber
            ),
            0,
            null
        );
    }
}
