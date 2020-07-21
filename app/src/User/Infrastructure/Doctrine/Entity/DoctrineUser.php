<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Entity;

use App\User\Domain\Address\AddressUuid;
use App\User\Domain\UserUuid;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="projection_users",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="uuid_unq",
 *             columns={"uuid"}
 *         )
 *     }
 * )
 */
class DoctrineUser
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="uuid", type="user_uuid", length=36)
     */
    private UserUuid $userUuid;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $surname;

    /**
     * @ORM\Column(name="address_1_uuid", type="address_uuid", length=36, nullable=true)
     */
    private ?AddressUuid $address1Uuid;

    /**
     * @ORM\Column(name="address_1_street_name", type="string", nullable=true)
     */
    private ?string $address1StreetName;

    /**
     * @ORM\Column(name="address_1_street_number", type="string", nullable=true)
     */
    private ?string $address1StreetNumber;

    /**
     * @ORM\Column(name="address_2_uuid", type="address_uuid", length=36, nullable=true)
     */
    private ?AddressUuid $address2Uuid;

    /**
     * @ORM\Column(name="address_2_street_name", type="string", nullable=true)
     */
    private ?string $address2StreetName;

    /**
     * @ORM\Column(name="address_2_street_number", type="string", nullable=true)
     */
    private ?string $address2StreetNumber;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdAt;

    public function __construct(
        UserUuid $userUuid,
        string $name,
        string $surname,
        ?AddressUuid $address1Uuid,
        ?string $address1StreetName,
        ?string $address1StreetNumber,
        ?AddressUuid $address2Uuid,
        ?string $address2StreetName,
        ?string $address2StreetNumber,
        ?DateTimeImmutable $createdAt
    ) {
        $this->userUuid = $userUuid;
        $this->name = $name;
        $this->surname = $surname;
        $this->address1Uuid = $address1Uuid;
        $this->address1StreetName = $address1StreetName;
        $this->address1StreetNumber = $address1StreetNumber;
        $this->address2Uuid = $address2Uuid;
        $this->address2StreetName = $address2StreetName;
        $this->address2StreetNumber = $address2StreetNumber;
        $this->createdAt = $createdAt ?? new DateTimeImmutable();
    }

    public function getUserUuid(): UserUuid
    {
        return $this->userUuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function updateName(string $name): void
    {
        $this->name = $name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getAddress1Uuid(): ?AddressUuid
    {
        return $this->address1Uuid;
    }

    public function getAddress1StreetName(): ?string
    {
        return $this->address1StreetName;
    }

    public function getAddress1StreetNumber(): ?string
    {
        return $this->address1StreetNumber;
    }

    public function getAddress2Uuid(): ?AddressUuid
    {
        return $this->address2Uuid;
    }

    public function getAddress2StreetName(): ?string
    {
        return $this->address2StreetName;
    }

    public function getAddress2StreetNumber(): ?string
    {
        return $this->address2StreetNumber;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
