<?php

declare(strict_types=1);

namespace App\User\Domain\Address;

use App\User\Domain\Exception\Address\AddressUuidCannotBeCreatedException;
use App\User\Domain\UuidInterface;
use Ramsey\Uuid\Uuid;

final class AddressUuid implements UuidInterface
{
    private string $uuid;

    private function __construct(string $uuid)
    {
        $this->uuid = Uuid::fromString($uuid)->toString();
    }

    public static function fromString(string $uuid): self
    {
        if (!Uuid::isValid($uuid)) {
            throw new AddressUuidCannotBeCreatedException($uuid);
        }

        return new self($uuid);
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

    public function __toString()
    {
        return (string) $this->uuid;
    }
}
