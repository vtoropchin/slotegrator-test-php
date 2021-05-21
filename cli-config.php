<?php declare(strict_types=1);

/**
 * @var \Src\Core\Application $app
 */
require_once __DIR__ . "/bootstrap.php";

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($app->getEntityManager());
