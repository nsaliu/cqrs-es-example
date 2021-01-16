<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Infrastructure\Uuid\UuidInterface;
use App\User\Domain\Address\AddressUuid;
use App\User\Domain\UserUuid;

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

    public function getAggregateUuid(): UuidInterface
    {
        return $this->userUuid;
    }

    public function getAddressUuid(): AddressUuid
    {
        return $this->addressUuid;
    }
}
