<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Enums\HttpResponseStatus;
use App\Repositories\UserRepository;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Factory\ResponseFactory;

class RequireApiKey
{
    public function __construct(
        private ResponseFactory $factory,
        private UserRepository $userRepository,
    ) {
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        if (! $request->hasHeader('X-API-Key')) {
            return $this->sendResponse(
                'Api key is missing',
                HttpResponseStatus::BadRequest->value,
            );
        }

        $user = $this->userRepository
            ->find('api_key_hashed', $request->getHeaderLine('X-API-Key'));

        if (false === $user) {
            return $this->sendResponse(
                'Wrong api key',
                HttpResponseStatus::Unauthorized->value,
            );
        }

        return $handler->handle($request);
    }

    private function sendResponse(mixed $body, int $status): Response
    {
        $response = $this->factory->createResponse();

        $response->getBody()->write(json_encode($body));

        return $response->withStatus($status);
    }
}
