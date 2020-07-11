<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\UserUuid;

final class UpdateUserNameCommand implements CommandInterface
{
    private UserUuid $uuid;

    private string $userName;

    public function __construct(
        UserUuid $uuid,
        string $userName
    ) {
        $this->uuid = $uuid;
        $this->userName = $userName;
    }

    public function getUuid(): UserUuid
    {
        return $this->uuid;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }
}
