<?php declare(strict_types=1);

return [
    'dbname'   => getenv('DB_NAME'),
    'user'     => getenv('DB_USER'),
    'password' => getenv('DB_PASSWORD'),
    'host'     => getenv('DB_HOST'),
    'driver'   => getenv('DB_DRIVER'),

    'entityDirs' => [
        __DIR__ . '/../src/Core/Dal/Entity',
        __DIR__ . '/../src/User/Dal/Entity',
        __DIR__ . '/../src/Prize/Dal/Entity',
    ],

    'types' => [
        'PrizeTypeEnum' => \Src\Prize\Dal\Enum\PrizeTypeEnum::class,
    ],
];
