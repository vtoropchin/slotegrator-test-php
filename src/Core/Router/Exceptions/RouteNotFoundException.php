<?php declare(strict_types=1);


namespace Src\Core\Router\Exceptions;


use Throwable;

/**
 * Class RouteNotFoundException
 * @package Src\Core\Router\Exceptions
 */
class RouteNotFoundException extends RouteException
{
    /**
     * RouteNotFoundException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "Page not found", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
