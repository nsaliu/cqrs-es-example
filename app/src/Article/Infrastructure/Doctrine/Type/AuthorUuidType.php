<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Doctrine\Type;

use App\Article\Domain\AuthorUuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Throwable;

final class AuthorUuidType extends Type
{
    private const TYPE_NAME = 'author_uuid';

    public function convertToDatabaseValue(
        $value,
        AbstractPlatform $platform
    ): string {
        if ($value instanceof AuthorUuid) {
            return $value->toString();
        }

        try {
            return AuthorUuid::fromString($value)->toString();
        } catch (Throwable $exception) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), [AuthorUuid::class]);
        }
    }

    public function convertToPHPValue(
        $value,
        AbstractPlatform $platform
    ): AuthorUuid {
        if ($value instanceof AuthorUuid) {
            return $value;
        }

        try {
            return AuthorUuid::fromString($value);
        } catch (Throwable $exception) {
            throw ConversionException::conversionFailed($value, $this->getName());
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
