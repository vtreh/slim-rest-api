<?php

declare(strict_types=1);

use App\Database;
use Slim\Views\PhpRenderer;

return [
    Database::class => fn () => new Database(
        db: $_ENV['DB_NAME'],
        user: $_ENV['DB_USER'],
        host: $_ENV['DB_HOST'],
        password: $_ENV['DB_PASS'],
    ),
    PhpRenderer::class => function () {
        $renderer = new PhpRenderer(__DIR__ . '/../views');
        $renderer->setLayout('layout.php');
        return $renderer;
    },
];
