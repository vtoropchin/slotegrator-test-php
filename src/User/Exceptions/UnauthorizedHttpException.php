<?php declare(strict_types=1);


namespace Src\User\Exceptions;


use Throwable;

/**
 * Class UnauthorizedHttpException
 * @package Src\User\Exceptions
 */
class UnauthorizedHttpException extends \Exception
{
    /**
     * UnauthorizedHttpException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "Unauthorized", $code = 401, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
