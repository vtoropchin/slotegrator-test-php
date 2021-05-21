<?php declare(strict_types=1);


namespace Src\Prize\Dal\Enum;


use Src\Core\Dal\DbType\AbstractEnum;

/**
 * Class PrizeTypeEnum
 * @package Src\Prize\Dal\Enum
 */
class PrizeTypeEnum extends AbstractEnum
{
    protected const DEFAULT_VALUE = self::MONEY;

    public const MONEY = 'money';
    public const BONUS = 'bonus';
    public const THING = 'thing';

    public const VALUES = [
        self::MONEY,
        self::BONUS,
        self::THING,
    ];
}
