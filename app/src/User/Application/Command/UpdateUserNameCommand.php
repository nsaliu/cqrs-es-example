<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\UserUuid;

final class UpdateUserNameCommand implements CommandInterface
{
    private UserUuid $userUuid;

    private string $userName;

    public function __construct(
        UserUuid $userUuid,
        string $userName
    ) {
        $this->userUuid = $userUuid;
        $this->userName = $userName;
    }

    public function getUserUuid(): UserUuid
    {
        return $this->userUuid;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }
}
