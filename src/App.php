<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestResponseArgs;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Repositories\ProductRepository;
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
$app->get('/api/products', function (Request $request, Response $response) {
    $productRepository = $this->get(ProductRepository::class);
    $data = $productRepository->getAll();

    $response->getBody()->write(json_encode($data));

    return $response;
});

$app->get('/api/products/{id:[0-9]+}', function (Request $request, Response $response) {
    $response->getBody()
        ->write(json_encode($request->getAttribute('product')));

    return $response;
})->add(GetProduct::class);

return $app;
