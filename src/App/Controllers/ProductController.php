<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\ProductRepository;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ProductController
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {
    }

    public function index(Request $request, Response $response): Response
    {
        $products = $this->productRepository->getAll();

        $response->getBody()->write(json_encode($products));

        return $response;
    }

    public function show(Request $request, Response $response): Response
    {
        $product = $request->getAttribute('product');

        $response->getBody()->write(json_encode($product));

        return $response;
    }
}
