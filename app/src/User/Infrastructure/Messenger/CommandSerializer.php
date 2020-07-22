<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Messenger;

use App\User\Application\Command\CommandInterface;
use App\User\Application\Command\RegisterUserCommand;
use App\User\Application\Command\UpdateUserNameCommand;
use App\User\Domain\UserUuid;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Stamp\StampInterface;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

final class CommandSerializer implements CommandSerializerInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param array<mixed> $encodedEnvelope
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        $envelop = $this->serializer->decode($encodedEnvelope);

        if ($envelop->getMessage() instanceof CommandInterface) {
            $command = $this->deserializeCommandMessage(
                $envelop,
                $encodedEnvelope
            );

            if ($command === null) {
                throw new MessageDecodingFailedException('Unable to decode command, null given');
            }

            return new Envelope(
                $command,
                $this->getStamps($envelop->all())
            );
        }

        return $envelop;
    }

    /**
     * @return array<mixed>
     */
    public function encode(Envelope $envelope): array
    {
        if ($envelope->getMessage() instanceof CommandInterface) {
            /** @var CommandInterface $originalMessage */
            $originalMessage = $envelope->getMessage();

            $encodedMessage = $this->serializer->encode($envelope);

            $messageBody = json_decode($encodedMessage['body'], true);

            $messageBody['uuid'] = $originalMessage->getUuid()->toString();

            $encodedMessage['body'] = json_encode($messageBody);

            return $encodedMessage;
        }

        return $this->serializer->encode($envelope);
    }

    /**
     * @param array<mixed> $encodedEnvelope
     */
    private function deserializeCommandMessage(
        Envelope $envelope,
        array $encodedEnvelope
    ): ?CommandInterface {
        $body = json_decode($encodedEnvelope['body'], true);
        $message = $envelope->getMessage();

        if ($message instanceof RegisterUserCommand) {
            return new RegisterUserCommand(
                UserUuid::fromString($body['uuid']),
                $message->getName(),
                $message->getSurname()
            );
        }

        if ($message instanceof UpdateUserNameCommand) {
            return new UpdateUserNameCommand(
                UserUuid::fromString($body['uuid']),
                $message->getName()
            );
        }

        return null;
    }

    /**
     * @param array<mixed|StampInterface> $stamps
     *
     * @return StampInterface[]
     */
    private function getStamps(array $stamps): array
    {
        $results = [];

        foreach ($stamps as $fccn => $stampArray) {
            foreach ($stampArray as $stamp) {
                $results[] = $stamp;
            }
        }

        return $results;
    }
}
