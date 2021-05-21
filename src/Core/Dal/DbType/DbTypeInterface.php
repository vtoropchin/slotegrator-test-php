<?php declare(strict_types=1);

namespace Src\Core\Dal\DbType;

use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * interface DbTypeInterface
 */
interface DbTypeInterface
{
    /**
     * Returns short class name as a type name (DBAL doesn't support slashes in names)
     *
     * @return string
     * @throws \ReflectionException
     */
    public static function getDbName() : string;

    /**
     * @noinspection ReturnTypeCanBeDeclaredInspection
     *               The type of the return value can not be specified
     *               because base class Doctrine\DBAL\Types\Type doesn't have it.
     *
     * @return string
     * @throws \ReflectionException
     */
    public function getName(): string;

    /**
     * Converts a value from its PHP representation to its database representation
     * of this type.
     *
     * @param mixed            $value    The value to convert.
     * @param AbstractPlatform $platform The currently used database platform.
     *
     * @return mixed The database representation of the value.
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform);

    /**
     * Converts a value from its database representation to its PHP representation
     * of this type.
     *
     * @param mixed            $value    The value to convert.
     * @param AbstractPlatform $platform The currently used database platform.
     *
     * @return mixed The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform);

    /**
     * Gets the SQL declaration snippet for a field of this type.
     *
     * @noinspection ReturnTypeCanBeDeclaredInspection
     *               The type of the return value can not be specified
     *               because base class Doctrine\DBAL\Types\Type doesn't have it.
     *
     * @param array            $fieldDeclaration The field declaration.
     * @param AbstractPlatform $platform         The currently used database platform.
     *
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string;
}
