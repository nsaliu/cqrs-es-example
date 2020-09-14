<?php

declare(strict_types=1);

namespace App\User\Application\Query;

use App\User\Domain\UserId;

final class GetUserByUserUuidQuery
{
    private UserId $userUuid;

    public function __construct(
        UserId $userUuid
    ) {
        $this->userUuid = $userUuid;
    }

    public function getUserUuid(): UserId
    {
        return $this->userUuid;
    }
}
