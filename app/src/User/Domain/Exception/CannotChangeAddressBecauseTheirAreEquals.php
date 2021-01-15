<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

use Exception;

final class CannotChangeAddressBecauseTheirAreEquals extends Exception
{
    public function __construct(
        string $oldStreetName,
        int $oldStreetNumber,
        string $newStreetName,
        int $newStreetNumber
    ) {
        parent::__construct(
            sprintf(
                'Old Address and new Address are the same. Old address: %s, %d - new address: %s, %d',
                $oldStreetName,
                $oldStreetNumber,
                $newStreetName,
                $newStreetNumber
            ),
            0,
            null
        );
    }
}
