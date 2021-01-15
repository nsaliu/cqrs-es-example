<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\UserUuid;

final class UpdateUserNameCommand implements CommandInterface
{
    private UserUuid $userUuid;

    private string $name;

    public function __construct(
        UserUuid $userUuid,
        string $name
    ) {
        $this->userUuid = $userUuid;
        $this->name = $name;
    }

    public function getAggregateUuid(): UserUuid
    {
        return $this->userUuid;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
