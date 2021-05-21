<?php declare(strict_types=1);


namespace Src\Prize\Exceptions;


use Throwable;

/**
 * Class PrizeNumbersIsLessThanZeroException
 * @package Src\Prize\Exceptions
 */
class PrizeNumbersIsLessThanZeroException extends \RuntimeException
{
    public function __construct($message = "The number of prizes cannot be less than zero", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
