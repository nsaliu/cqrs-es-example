<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Type;

use App\User\Domain\Address\AddressUuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Throwable;

final class AddressUuidType extends Type
{
    private const TYPE_NAME = 'address_uuid';

    public function convertToDatabaseValue(
        $value,
        AbstractPlatform $platform
    ): ?string {
        if ($value === null) {
            return null;
        }

        if ($value instanceof AddressUuid) {
            return $value->toString();
        }

        try {
            return AddressUuid::fromString($value)->toString();
        } catch (Throwable $exception) {
            throw ConversionException::conversionFailedInvalidType(
                $value,
                $this->getName(),
                [AddressUuid::class]
            );
        }
    }

    public function convertToPHPValue(
        $value,
        AbstractPlatform $platform
    ): ?AddressUuid {
        if ($value === null) {
            return null;
        }

        if ($value instanceof AddressUuid) {
            return $value;
        }

        try {
            return AddressUuid::fromString($value);
        } catch (Throwable $exception) {
            throw ConversionException::conversionFailed(
                $value,
                $this->getName()
            );
        }
    }


    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getName(): string
    {
        return self::TYPE_NAME;
    }
}
