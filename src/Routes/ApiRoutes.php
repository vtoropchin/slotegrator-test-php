<?php declare(strict_types=1);

namespace Src\Routes;

use DI\Container;
use Src\Prize\Controllers\PrizeController;
use Src\User\Controllers\UserController;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
use Src\User\Http\Middleware\AuthMiddleware;
use WoohooLabs\Harmony\Harmony;
use function FastRoute\simpleDispatcher;

/**
 * Class ApiRoutes
 */
class ApiRoutes
{
    /**
     * @var Container
     */
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return Dispatcher
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __invoke(): Dispatcher
    {
        return simpleDispatcher(function (RouteCollector $r) {
            $r->addGroup('/api/v1', function () use ($r) {
                $harmony = $this->container->make(Harmony::class);
                $harmony->addMiddleware($this->container->make(AuthMiddleware::class));
                $harmony->run();
                $r->addRoute('GET', '/get-random-prize', [PrizeController::class, 'getRandomPrize']);
            });
        });
    }
}
