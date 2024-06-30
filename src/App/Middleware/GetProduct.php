<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Repositories\ProductRepository;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class GetProduct
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $context = RouteContext::fromRequest($request);
        $route = $context->getRoute();
        $id = $route->getArgument('id');

        $product = $this->productRepository->getById((int) $id);

        if (false === $product) {
            throw new HttpNotFoundException($request, "Product id: {$id} not found");
        }

        $request = $request->withAttribute('product', $product);

        return $handler->handle($request);
    }
}
