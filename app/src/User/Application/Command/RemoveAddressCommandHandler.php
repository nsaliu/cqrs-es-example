<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\UserUuid;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

final class RemoveAddressCommandHandler implements MessageSubscriberInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(RemoveAddressCommand $event): void
    {
        /** @var UserUuid $userUuid */
        $userUuid = $event->getUuid();

        $user = $this->userRepository->get($userUuid);

        $user->removeAddress(
            $userUuid,
            $event->getAddressUuid()
        );

        $this->userRepository->save($user);
    }

    /**
     * @return iterable<string>
     */
    public static function getHandledMessages(): iterable
    {
        yield RemoveAddressCommand::class;
    }
}
