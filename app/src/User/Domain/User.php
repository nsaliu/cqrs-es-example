<?php

declare(strict_types=1);

namespace App\User\Domain;

use App\User\Domain\Address\Address;
use App\User\Domain\Event\AddAddress;
use App\User\Domain\Event\AddressWasAdded;
use App\User\Domain\Event\AddressWasRemoved;
use App\User\Domain\Event\RemoveAddress;
use App\User\Domain\Event\UpdateUserName;
use App\User\Domain\Event\UserNameWasUpdated;
use App\User\Domain\Event\UserWasRegistered;
use App\User\Domain\Event\RegisterNewUser;
use App\User\Domain\Exception\AddressLimitReached;
use App\User\Domain\Exception\Address\AddressStreetNameIsInvalidException;
use App\User\Domain\Exception\Address\AddressStreetNumberIsInvalidException;
use App\User\Domain\Exception\ArressIsAlreadyAssociatedToUserException;
use App\User\Domain\Exception\CannotRemoveNonExistentAddressException;
use App\User\Domain\Exception\UserNamePropertyIsTooShort;
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

    public static function create(UserUuid $userUuid): self
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

    public function registerUser(RegisterNewUser $event): void
    {
        if (mb_strlen($event->getName()) === 0) {
            throw new UserNamePropertyIsTooShort();
        }

        if (mb_strlen($event->getSurname()) === 0) {
            throw new UserNamePropertyIsTooShort();
        }

        $this->recordThat(
            new UserWasRegistered(
                $event->getName(),
                $event->getSurname()
            )
        );
    }

    public function updateName(UpdateUserName $event): void
    {
        if (mb_strlen($event->getName()) === 0) {
            throw new UserNamePropertyIsTooShort();
        }

        $this->recordThat(
            new UserNameWasUpdated($event->getName())
        );
    }

    public function addAddress(AddAddress $event): void
    {
        if (count($this->addresses) >= 2) {
            throw new AddressLimitReached();
        }

        if (array_key_exists($event->getAddressUuid()->toString(), $this->addresses)) {
            throw new ArressIsAlreadyAssociatedToUserException($event->getAddressUuid());
        }

        if (mb_strlen($event->getStreetName()) === 0) {
            throw new AddressStreetNameIsInvalidException($event->getStreetName());
        }

        if ($event->getStreetNumber() <= 0) {
            throw new AddressStreetNumberIsInvalidException($event->getStreetNumber());
        }

        $this->recordThat(
            new AddressWasAdded(
                $event->getAddressUuid(),
                $event->getStreetName(),
                $event->getStreetNumber()
            )
        );
    }

    public function removeAddress(RemoveAddress $event): void
    {
        if (!array_key_exists($event->getAddressUuid()->toString(), $this->addresses)) {
            throw new CannotRemoveNonExistentAddressException($event->getAddressUuid());
        }

        $this->recordThat(
            new AddressWasRemoved(
                $event->getUserUuid(),
                $event->getAddressUuid()
            )
        );
    }

    public function applyUserWasRegistered(UserWasRegistered $event): void
    {
        $this->name = $event->getName();
        $this->surname = $event->getSurname();
    }

    public function applyUserNameWasUpdated(UserNameWasUpdated $event): void
    {
        $this->name = $event->getName();
    }

    public function applyAddressWasAdded(AddressWasAdded $event): void
    {
        $this->addresses[$event->getAddressUuid()->toString()] = new Address(
            $event->getAddressUuid(),
            $event->getStreetName(),
            $event->getStreetNumber()
        );
    }

    public function applyAddressWasRemoved(AddressWasRemoved $event): void
    {
        unset($this->addresses[$event->getAddressUuid()->toString()]);
    }
}
