<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\ProductController;
use App\Controllers\SignupController;
use App\Middleware\AddJsonResponseHeader;
use App\Middleware\GetProduct;
use App\Middleware\RequireApiKey;

$app->get('/', HomeController::class);

$app->get('/signup', [SignupController::class, 'signup']);

$app->add(RequireApiKey::class);

$app->group('/api', function (RouteCollectorProxy $group) {
    $group->get('/products', [ProductController::class, 'index']);
    $group->post('/products', [ProductController::class, 'store']);

    $group->group('', function (RouteCollectorProxy $group) {
        $group->get('/products/{id:[0-9]+}', [ProductController::class, 'show']);
        $group->patch('/products/{id:[0-9]+}', [ProductController::class, 'update']);
        $group->delete('/products/{id:[0-9]+}', [ProductController::class, 'destroy']);
    })->add(GetProduct::class);
})->add(AddJsonResponseHeader::class);