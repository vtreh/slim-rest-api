<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestResponseArgs;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\ProductController;
use App\Middleware\AddJsonResponseHeader;
use App\Middleware\GetProduct;

$container = (new ContainerBuilder())
    ->addDefinitions(APP_ROOT . '/config/definitions.php')
    ->build();

AppFactory::setContainer($container);
$app = AppFactory::create();

// Retrieve Route Params as Separate Vars
$collector = $app->getRouteCollector();
$collector->setDefaultInvocationStrategy(new RequestResponseArgs());

// Get Data from POST Request Body
$app->addBodyParsingMiddleware();

// Set Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType('application/json');

// Add Custom Middlewares
$app->add(new AddJsonResponseHeader());

// Register Routes
$app->group('/api', function (RouteCollectorProxy $group) {
    $group->get('/products', [ProductController::class, 'index']);
    $group->post('/products', [ProductController::class, 'store']);

    $group->group('', function (RouteCollectorProxy $group) {
        $group->get('/products/{id:[0-9]+}', [ProductController::class, 'show']);
        $group->patch('/products/{id:[0-9]+}', [ProductController::class, 'update']);
        $group->delete('/products/{id:[0-9]+}', [ProductController::class, 'destroy']);
    })->add(GetProduct::class);
});

return $app;
