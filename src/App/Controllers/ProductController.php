<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Enums\HttpResponseStatus;
use App\Repositories\ProductRepository;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Valitron\Validator;

class ProductController
{
    public function __construct(
        private ProductRepository $productRepository,
        private Validator $validator,
    ) {
        $this->validator->mapFieldsRules([
            'name' => ['required'],
            'size' => ['required', 'integer', ['min', 1], ['max', 10]],
        ]);
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

    public function store(Request $request, Response $response): Response
    {
        $body = $request->getParsedBody();

        $this->validator = $this->validator->withData($body);

        if (! $this->validator->validate()) {
            $response->getBody()->write(json_encode(
                $this->validator->errors(),
            ));

            return $response->withStatus(HttpResponseStatus::Unprocessable->value);
        }

        $id = $this->productRepository->create($body);

        $response->getBody()->write(json_encode([
            'message' => 'Product Created',
            'id' => $id,
        ]));

        return $response->withStatus(HttpResponseStatus::Created->value);
    }

    public function update(Request $request, Response $response, string $id): Response
    {
        $body = $request->getParsedBody();

        $this->validator = $this->validator->withData($body);

        if (! $this->validator->validate()) {
            $response->getBody()->write(json_encode(
                $this->validator->errors(),
            ));

            return $response->withStatus(HttpResponseStatus::Unprocessable->value);
        }

        $updated = $this->productRepository->update(+$id, $body);

        $response->getBody()->write(json_encode([
            'message' => $updated ? 'Successfully Updated' : 'Not Updated',
        ]));

        $status = $updated
            ? HttpResponseStatus::Ok->value
            : HttpResponseStatus::Unprocessable->value;

        return $response->withStatus($status);
    }

    public function destroy(Request $request, Response $response, string $id): Response
    {
        $deleted = $this->productRepository->delete($id);

        $response->getBody()->write(json_encode([
            'message' => $deleted ? 'Successfully Deleted' : 'Failed to Delete',
        ]));

        $status = $deleted
            ? HttpResponseStatus::Ok->value
            : HttpResponseStatus::NotFound->value;

        return $response->withStatus($status);
    }
}
