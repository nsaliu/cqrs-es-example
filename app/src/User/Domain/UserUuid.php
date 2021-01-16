<?php

declare(strict_types=1);

namespace App\User\Domain;

use App\Shared\Infrastructure\Uuid\UuidInterface;
use App\User\Domain\Exception\UserUuidCannotBeCreatedException;
use Ramsey\Uuid\Uuid;

final class UserUuid implements UuidInterface
{
    private string $uuid;

    private function __construct(string $uuid)
    {
        $this->uuid = Uuid::fromString($uuid)->toString();
    }

    public function __toString()
    {
        return (string) $this->uuid;
    }

    public static function fromString(string $aggregateRootId): self
    {
        if (!Uuid::isValid($aggregateRootId)) {
            throw new UserUuidCannotBeCreatedException($aggregateRootId);
        }

        return new self($aggregateRootId);
    }

    public static function createNew(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function equalsTo(UuidInterface $uuid): bool
    {
        return $this->toString() === $uuid->toString();
    }

    public function toString(): string
    {
        return $this->__toString();
    }
}
