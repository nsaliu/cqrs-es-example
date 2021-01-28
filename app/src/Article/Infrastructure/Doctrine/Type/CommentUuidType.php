<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Doctrine\Type;

use App\Article\Domain\CommentUuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Throwable;

final class CommentUuidType extends Type
{
    private const TYPE_NAME = 'comment_uuid';

    public function convertToDatabaseValue(
        $value,
        AbstractPlatform $platform
    ): string {
        if ($value instanceof CommentUuid) {
            return $value->toString();
        }

        try {
            return CommentUuid::fromString($value)->toString();
        } catch (Throwable $exception) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), [CommentUuid::class]);
        }
    }

    public function convertToPHPValue(
        $value,
        AbstractPlatform $platform
    ): CommentUuid {
        if ($value instanceof CommentUuid) {
            return $value;
        }

        try {
            return CommentUuid::fromString($value);
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
