<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestResponseArgs;
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

// Set Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType('application/json');

// Add Custom Middlewares
$app->add(new AddJsonResponseHeader());

// Register Routes
$app->get('/api/products', [ProductController::class, 'index']);

$app->get('/api/products/{id:[0-9]+}', [ProductController::class, 'show'])
    ->add(GetProduct::class);

return $app;
