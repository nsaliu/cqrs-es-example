<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\User\Domain\Address\AddressUuid;
use App\User\Domain\UserUuid;

final class RemoveAddress
{
    private UserUuid $userUuid;

    private AddressUuid $addressUuid;

    public function __construct(
        UserUuid $userUuid,
        AddressUuid $addressUuid
    ) {
        $this->userUuid = $userUuid;
        $this->addressUuid = $addressUuid;
    }

    public function getUserUuid(): UserUuid
    {
        return $this->userUuid;
    }

    public function getAddressUuid(): AddressUuid
    {
        return $this->addressUuid;
    }
}
