<?php

declare(strict_types=1);

namespace App\User\Domain;

use App\User\Domain\Exception\UserIdCannotBeCreatedException;
use Ramsey\Uuid\Uuid;

final class UserUuid implements UuidInterface
{
    private string $uuid;

    private function __construct(string $uuid)
    {
        $this->uuid = Uuid::fromString($uuid)->toString();
    }

    public static function createFromString(string $uuid): self
    {
        if (!Uuid::isValid($uuid)) {
            throw new UserIdCannotBeCreatedException($uuid);
        }

        return new self($uuid);
    }

    public static function createNew(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function toString(): string
    {
        return $this->__toString();
    }

    public function __toString()
    {
        return (string) $this->uuid;
    }
}
