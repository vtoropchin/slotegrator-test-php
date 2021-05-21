<?php declare(strict_types=1);


namespace Src\Prize\Exceptions;


use Throwable;

/**
 * Class WrongPrizeTypeException
 * @package Src\Prize\Exceptions
 */
class WrongPrizeTypeException extends \RuntimeException
{
    /**
     * WrongPrizeTypeException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "Wrong type of the prize", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
