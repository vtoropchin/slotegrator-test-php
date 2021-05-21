<?php declare(strict_types=1);


namespace Src\Core;


use DI\ContainerBuilder;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use FastRoute\Dispatcher;
use Src\Core\Router\Exceptions\RouteNotAllowedException;
use Src\Core\Router\Exceptions\RouteNotFoundException;
use Src\Routes\ApiRoutes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use WoohooLabs\Harmony\Harmony;

/**
 * Class Application
 * @package Src\Core
 */
class Application
{
    private static Application $applicationInstance;

    protected array $config = [];

    protected EntityManager $entityManager;

    protected \DI\Container $container;

    /**
     * Application constructor.
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Doctrine\DBAL\Exception
     * @throws \Doctrine\ORM\ORMException
     */
    public function __construct()
    {
        $this->init();
    }

    public static function getApp(): Application
    {
        return self::$applicationInstance;
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \JsonException
     */
    public function runApi(): void
    {
        $request = $this->container->get(Request::class);
        $httpMethod = $request->getMethod();
        $uri = $request->getPathInfo();
        $uri = rawurldecode($uri);

        $apiRoutes = $this->container->get(ApiRoutes::class);
        try {
            $dispatcher = $apiRoutes();
            $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

            switch ($routeInfo[0]) {
                case Dispatcher::NOT_FOUND:
                    throw new RouteNotFoundException();
                case Dispatcher::METHOD_NOT_ALLOWED:
                    throw new RouteNotAllowedException();
                case Dispatcher::FOUND:
                    $routeHandler = $routeInfo[1];
                    $vars = $routeInfo[2];
                    $response = $this->container->call($routeHandler, $vars);
                    $response->send();
            }
        } catch (\Throwable $e) {
            $code = $e->getCode();
            $response = new Response(
                json_encode(
                    [
                        'error' => $e->getMessage(),
                    ],
                    JSON_THROW_ON_ERROR),
                $code > 0 ? $code : 500
            );
            $response->send();
        }
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function runCli(): void
    {
        $cli = $this->container->get(\Symfony\Component\Console\Application::class);

        $this->runMiddlewares();

        foreach ($this->getConfig('[commands]') as $command) {
            $cli->add($this->container->get($command));
        }

        $cli->run();
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function runMiddlewares(): void
    {
        /** @var Harmony $harmony */
        $harmony = $this->container->make(Harmony::class);

        $middlewares = $this->getConfig('[middleware]');
        foreach ($middlewares as $middleware) {
            $harmony->addMiddleware(new $middleware);
        }

        $harmony->run();
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Doctrine\DBAL\Exception
     * @throws \Doctrine\ORM\ORMException
     */
    protected function init(): void
    {
        $this->loadConfigs();
        $this->registerPhpDi();
        $this->registerDoctrineOrm();
        $this->runMiddlewares();

        $this::$applicationInstance = $this;
    }

    protected function loadConfigs(): void
    {
        $dotenv = new \Symfony\Component\Dotenv\Dotenv();
        $dotenv->usePutenv();
        $dotenv->load(__DIR__ . '/../../.env');

        $configDir = __DIR__ . '/../../config/';
        $configFiles = scandir($configDir);

        foreach ($configFiles as $configFile) {
            $path = $configDir . $configFile;
            if (is_file($path)) {
                $pathInfo = pathinfo($path);
                $this->config[$pathInfo['filename']] = require $path;
            }
        }
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws \Doctrine\ORM\ORMException
     */
    protected function registerDoctrineOrm(): void
    {
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;
        $config = Setup::createAnnotationMetadataConfiguration(
            $this->getConfig('[doctrine][entityDirs]'),
            $isDevMode,
            $proxyDir,
            $cache,
            $useSimpleAnnotationReader
        );

        $connectionParams = [
            'dbname'   => $this->getConfig('[doctrine][dbname]'),
            'user'     => $this->getConfig('[doctrine][user]'),
            'password' => $this->getConfig('[doctrine][password]'),
            'host'     => $this->getConfig('[doctrine][host]'),
            'driver'   => $this->getConfig('[doctrine][driver]'),
        ];

        $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);

        $this->entityManager = EntityManager::create($conn, $config);

        $this->registerDbTypes();
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    protected function registerDbTypes(): void
    {
        $types = $this->getConfig('[doctrine][types]');

        foreach ($types as $name => $className) {
            Type::addType($name, $className);
        }
    }

    protected function registerPhpDi(): void
    {
        $containerBuilder = new ContainerBuilder();
        $config = $this->getConfig('[php-di]');
        $containerBuilder->addDefinitions($config);
        $this->container = $containerBuilder->build();
    }

    /**
     * @param string $path
     *
     * @return mixed
     */
    public function getConfig(string $path)
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        return $propertyAccessor->getValue($this->config, $path);
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @return \DI\Container
     */
    public function getContainer(): \DI\Container
    {
        return $this->container;
    }
}
