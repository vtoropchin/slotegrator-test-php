<?php declare(strict_types=1);


namespace Src\User\Http\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Src\Core\Http\Middlewares\CoreMiddleware;
use Src\User\Exceptions\UnauthorizedHttpException;
use Src\User\Services\AuthenticateService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthMiddleware
 * @package Src\User\Http\Middleware
 */
class AuthMiddleware extends CoreMiddleware
{
    /**
     * @var AuthenticateService
     */
    protected AuthenticateService $authenticateService;

    public function __construct(Request $request, AuthenticateService $authenticateService)
    {
        parent::__construct($request);
        $this->authenticateService = $authenticateService;
    }

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     * @throws UnauthorizedHttpException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $login = $this->request->getUser();
        $password = $this->request->getPassword();

        $isAuth = false;

        if ($login && $password) {
            $isAuth = $this->authenticateService->auth($login, $password);
        }

        if ($isAuth === false) {
            throw new UnauthorizedHttpException();
        }

        return $handler->handle($request);
    }
}
