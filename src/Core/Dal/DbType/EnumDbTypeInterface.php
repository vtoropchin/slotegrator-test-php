<?php declare(strict_types=1);

namespace Src\Core\Dal\DbType;

/**
 * Interface EnumDbTypeInterface
 */
interface EnumDbTypeInterface extends DbTypeInterface
{
    /**
     * @return int[]|string[]
     */
    public static function getAllValues() : array;

    /**
     * @return int|string|null
     */
    public static function getDefaultValue();

    /**
     * @param string|int $value
     *
     * @return bool
     */
    public static function hasValue($value) : bool;
}
