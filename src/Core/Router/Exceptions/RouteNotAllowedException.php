<?php declare(strict_types=1);


namespace Src\Core\Router\Exceptions;


use Throwable;

/**
 * Class RouteNotAllowedException
 * @package Src\Core\Router\Exceptions
 */
class RouteNotAllowedException extends RouteException
{
    /**
     * RouteNotFoundException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "Route not allowed", $code = 405, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
