<?php

declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Domain\User;
use App\User\Domain\UserUuid;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function get(UserUuid $user): User;
}
