<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestResponseArgs;

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
$app->addErrorMiddleware(true, true, true);

// Register Routes
require APP_ROOT . '/config/routes.php';

return $app;
