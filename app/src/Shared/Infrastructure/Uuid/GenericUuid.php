<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Uuid;

use App\Shared\Infrastructure\Uuid\Exception\InvalidUuidFormatException;
use Ramsey\Uuid\Uuid;

final class GenericUuid implements UuidInterface
{
    private string $uuid;

    private function __construct(string $uuid)
    {
        $this->uuid = Uuid::fromString($uuid)->toString();
    }

    public static function fromString(string $uuid): self
    {
        if (!Uuid::isValid($uuid)) {
            throw new InvalidUuidFormatException($uuid);
        }

        return new self($uuid);
    }

    public function equalsTo(UuidInterface $uuid): bool
    {
        return $this->toString() === $uuid->toString();
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
