Переименуйте `.env.example > .env`. Пропишите настройки.

Установите зависимости `composer install`

Синхронизируйте сущности доктрины с базой данных. Эта команда создаст все таблицы:
```
php vendor/doctrine/orm/bin/doctrine orm:schema-tool:update --force
```

Зарегистрируйте пользователя командой `php cli.php user:register`.

Добавьте призы `php cli.php prize:add`.

Для получения приза вызывать метод `GET /api/v1/get-random-prize`.
Доступ к методу требует авторизации по протоколу Basic auth.
