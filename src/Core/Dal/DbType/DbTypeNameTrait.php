<?php declare(strict_types=1);

namespace Src\Core\Dal\DbType;

/**
 * Trait DbTypeNameTrait
 */
trait DbTypeNameTrait
{
    /**
     * Returns short class name as a type name (DBAL doesn't support slashes in names)
     *
     * @return string
     */
    public static function getDbName() : string
    {
        return (new \ReflectionClass(static::class))->getShortName();
    }

    /**
     * @noinspection ReturnTypeCanBeDeclaredInspection
     *               The type of the return value can not be specified
     *               because base class Doctrine\DBAL\Types\Type doesn't have it.
     *
     * @return string
     */
    public function getName(): string
    {
        return static::getDbName();
    }
}
