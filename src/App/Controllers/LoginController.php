<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Enums\HttpResponseStatus;
use Slim\Views\PhpRenderer;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Valitron\Validator;
use App\Repositories\UserRepository;

class LoginController
{
    public function __construct(
        private PhpRenderer $view,
        private Validator $validator,
        private UserRepository $userRepository,
    ) {
        $this->validator->mapFieldsRules([
            'email' => ['required', 'email'],
            'password' => [['required'], ['lengthMin', 6]],
        ]);
    }

    public function show(Request $request, Response $response): Response
    {
        return $this->view->render($response, 'auth/login.php');
    }

    public function login(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $this->validator = $this->validator->withData($data);

        if (! $this->validator->validate()) {
            return $this->view->render($response, 'auth/login.php', [
                'errors' => $this->validator->errors(),
                'data' => $data,
            ]);
        }

        $user = $this->userRepository->find('email', $data['email']);

        if ($user && password_verify($data['password'], $user['password'])) {
            $_SESSION['user_id'] = $user['id'];

            return $response
                ->withHeader('Location', '/')
                ->withStatus(HttpResponseStatus::TemporaryRedirect->value);
        }

        return $this->view->render($response, 'auth/login.php', [
            'errors' => ['email' => ['Email or Password is invalid']],
            'data' => $data,
        ]);
    }

    public function logout(Request $request, Response $response): Response
    {
        session_destroy();

        return $response
            ->withHeader('Location', '/')
            ->withStatus(HttpResponseStatus::TemporaryRedirect->value);
    }
}