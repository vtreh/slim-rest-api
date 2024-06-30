<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\Repositories\ProductRepository;

$container = (new ContainerBuilder())
    ->addDefinitions(APP_ROOT . '/config/definitions.php')
    ->build();

AppFactory::setContainer($container);

$app = AppFactory::create();

$app->get('/api/products', function (Request $request, Response $response) {
    $productRepository = $this->get(ProductRepository::class);
    $data = $productRepository->getAll();

    $response->getBody()->write(json_encode($data));

    return $response->withHeader('Content-Type', 'application/json');
});

return $app;