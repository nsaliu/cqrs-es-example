<?php

declare(strict_types=1);

namespace App\User\Application\Query;

use App\User\Domain\UserUuid;

final class GetUserByUserUuidQuery
{
    private UserUuid $userUuid;

    public function __construct(
        UserUuid $userUuid
    ) {
        $this->userUuid = $userUuid;
    }

    public function getUserUuid(): UserUuid
    {
        return $this->userUuid;
    }
}
