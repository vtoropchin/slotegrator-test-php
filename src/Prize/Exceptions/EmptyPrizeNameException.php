<?php declare(strict_types=1);


namespace Src\Prize\Exceptions;


use Throwable;

/**
 * Class EmptyPrizeNameException
 * @package Src\Prize\Exceptions
 */
class EmptyPrizeNameException extends \RuntimeException
{
    /**
     * EmptyPrizeNameException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "Prize name cannot be empty", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
