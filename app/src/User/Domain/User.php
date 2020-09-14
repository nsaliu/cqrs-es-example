<?php

declare(strict_types=1);

namespace App\User\Domain;

use App\User\Domain\Address\Address;
use App\User\Domain\Address\AddressUuid;
use App\User\Domain\Event\AddressAdded;
use App\User\Domain\Event\AddressRemoved;
use App\User\Domain\Event\SpecificAddressAdded;
use App\User\Domain\Event\UserNameUpdated;
use App\User\Domain\Event\UserRegistered;
use App\User\Domain\Exception\Address\AddressStreetNameIsInvalidException;
use App\User\Domain\Exception\Address\AddressStreetNumberIsInvalidException;
use App\User\Domain\Exception\AddressLimitReached;
use App\User\Domain\Exception\ArressIsAlreadyAssociatedToUserException;
use App\User\Domain\Exception\CannotRemoveNonExistentAddressException;
use App\User\Domain\Exception\UserNamePropertyIsTooShort;
use App\User\Domain\Service\AddressDomainService;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;

final class User implements AggregateRoot
{
    use AggregateRootBehaviour;

    private string $name;

    private string $surname;

    /**
     * @var Address[]
     */
    private array $addresses = [];

    public static function create(UserId $userUuid): self
    {
        return new static($userUuid);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function registerUser(
        UserId $userUuid,
        string $name,
        string $surname
    ): void {
        if (mb_strlen($name) === 0) {
            throw new UserNamePropertyIsTooShort();
        }

        if (mb_strlen($surname) === 0) {
            throw new UserNamePropertyIsTooShort();
        }

        $this->recordThat(
            new UserRegistered(
                $userUuid,
                $name,
                $surname
            )
        );
    }

    public function updateName(
        UserId $userUuid,
        string $name
    ): void {
        if (mb_strlen($name) === 0) {
            throw new UserNamePropertyIsTooShort();
        }

        $this->recordThat(
            new UserNameUpdated(
                $userUuid,
                $name
            )
        );
    }

    public function addAddress(
        UserId $userUuid,
        AddressUuid $addressUuid,
        string $streetName,
        int $streetNumber,
        ?AddressDomainService $addressDomainService
    ): void {
        if (count($this->addresses) >= 2) {
            throw new AddressLimitReached();
        }

        if (array_key_exists($addressUuid->toString(), $this->addresses)) {
            throw new ArressIsAlreadyAssociatedToUserException($addressUuid);
        }

        if (mb_strlen($streetName) === 0) {
            throw new AddressStreetNameIsInvalidException($streetName);
        }

        if ($streetNumber <= 0) {
            throw new AddressStreetNumberIsInvalidException($streetNumber);
        }

        // Our complex business logic decide if we have to dispatch a specific Domain Event or not
        if ($addressDomainService !== null &&
            $addressDomainService->someComplexBusinessLogic($streetName)
        ) {
            $this->recordThat(
                new SpecificAddressAdded(
                    $userUuid,
                    $addressUuid,
                    $streetName,
                    $streetNumber,
                    $this->name,
                    $this->surname
                )
            );

            return;
        }

        $this->recordThat(
            new AddressAdded(
                $userUuid,
                $addressUuid,
                $streetName,
                $streetNumber
            )
        );
    }

    public function removeAddress(
        UserId $userUuid,
        AddressUuid $addressUuid
    ): void {
        if (!array_key_exists($addressUuid->toString(), $this->addresses)) {
            throw new CannotRemoveNonExistentAddressException($addressUuid);
        }

        $this->recordThat(
            new AddressRemoved(
                $userUuid,
                $addressUuid
            )
        );
    }

    public function applyUserRegistered(UserRegistered $event): void
    {
        $this->name = $event->getName();
        $this->surname = $event->getSurname();
    }

    public function applyUserNameUpdated(UserNameUpdated $event): void
    {
        $this->name = $event->getName();
    }

    public function applyAddressAdded(AddressAdded $event): void
    {
        $this->addresses[$event->getAddressUuid()->toString()] = new Address(
            $event->getAddressUuid(),
            $event->getStreetName(),
            $event->getStreetNumber()
        );
    }

    public function applySpecificAddressAdded(SpecificAddressAdded $event): void
    {
        $this->addresses[$event->getAddressUuid()->toString()] = new Address(
            $event->getAddressUuid(),
            $event->getStreetName(),
            $event->getStreetNumber()
        );
    }

    public function applyAddressRemoved(AddressRemoved $event): void
    {
        unset($this->addresses[$event->getAddressUuid()->toString()]);
    }
}
