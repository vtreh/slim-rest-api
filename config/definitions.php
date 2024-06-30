<?php

declare(strict_types=1);

use App\Database;

return [
    Database::class => fn () => new Database(
        db: $_ENV['DB_NAME'],
        user: $_ENV['DB_USER'],
        host: $_ENV['DB_HOST'],
        password: $_ENV['DB_PASS'],
    ),
];
