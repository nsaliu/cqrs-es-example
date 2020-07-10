<?php

declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Domain\User;
use App\User\Domain\UserUuid;

interface UserRepositoryInterface
{
    public function get(UserUuid $userId): User;

    public function save(User $user): void;

    public function update(User $user): void;
}
