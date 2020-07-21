<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Address\AddressUuid;
use App\User\Domain\UserUuid;
use App\User\Domain\UuidInterface;

final class RemoveAddressCommand implements CommandInterface
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

    public function getUuid(): UuidInterface
    {
        return $this->userUuid;
    }

    public function getAddressUuid(): AddressUuid
    {
        return $this->addressUuid;
    }
}
