<?php declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use Laminas\Diactoros\ServerRequestFactory;

return [
    \Symfony\Component\HttpFoundation\Request::class => \Symfony\Component\HttpFoundation\Request::createFromGlobals(),

    EntityManagerInterface::class => static function () {
        return \Src\Core\Application::getApp()->getEntityManager();
    },

    \WoohooLabs\Harmony\Harmony::class => \DI\create()->constructor(ServerRequestFactory::fromGlobals(), new \Laminas\Diactoros\Response()),

    \Src\User\Dal\Repository\UserRepository::class => static function () {
        return new \Src\User\Dal\Repository\UserRepository(
            \Src\Core\Application::getApp()->getEntityManager(),
            new \Doctrine\ORM\Mapping\ClassMetadata(\Src\User\Dal\Entity\User::class)
        );
    },

    \Src\Prize\Dal\Repository\PrizeRepository::class => static function () {
        return new \Src\Prize\Dal\Repository\PrizeRepository(
            \Src\Core\Application::getApp()->getEntityManager(),
            new \Doctrine\ORM\Mapping\ClassMetadata(\Src\Prize\Dal\Entity\Prize::class)
        );
    },
];
