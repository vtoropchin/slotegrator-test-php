<?php declare(strict_types=1);


namespace Src\User\Exceptions;


use Throwable;

/**
 * Class UserDoesNotExist
 * @package Src\User\Exceptions
 */
class UserDoesNotExist extends \Exception
{
    /**
     * UserDoesNotExist constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "User does not exist", $code = 422, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
