<?php

declare(strict_types=1);

namespace App\Controllers;

use Slim\Views\PhpRenderer;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Valitron\Validator;
use App\Repositories\UserRepository;

class SignupController
{
    public function __construct(
        private PhpRenderer $view,
        private Validator $validator,
        private UserRepository $userRepository,
    ) {
        $this->validator->mapFieldsRules([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => [['required'], ['lengthMin', 6]],
            'password_confirmation' => [['required'], ['equals', 'password']],
        ]);
    }

    public function show(Request $request, Response $response): Response
    {
        return $this->view->render($response, 'auth/signup.php');
    }

    public function signup(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $this->validator = $this->validator->withData($data);

        if (! $this->validator->validate()) {
            return $this->view->render($response, 'auth/signup.php', [
                'errors' => $this->validator->errors(),
                'data' => $data,
            ]);
        }

        unset($data['password_confirmation']);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['api_key'] = '';
        $api_key = bin2hex(random_bytes(16));
        $data['api_key_hashed'] = hash_hmac('sha256', $api_key, $_ENV['HASH_SECRET_KEY']);

        $newUserId = $this->userRepository->create($data);

        return $response;
    }
}
