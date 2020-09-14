<?php

declare(strict_types=1);

namespace App\User\Domain\Service;

final class AddressDomainService
{
    private string $addressToWatch;

    public function __construct(
        string $addressToWatch
    ) {
        $this->addressToWatch = $addressToWatch;
    }

    /**
     * This complex logic should remain inside our Domain instead replicated in multiple external services.
     */
    public function someComplexBusinessLogic(string $streetName): bool
    {
        if ($streetName === $this->addressToWatch) {
            return true;
        }

        return false;
    }
}
