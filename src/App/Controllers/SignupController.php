<?php

declare(strict_types=1);

namespace App\Controllers;

use Slim\Views\PhpRenderer;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Valitron\Validator;

class SignupController
{
    public function __construct(
        private PhpRenderer $view,
        private Validator $validator,
    ) {
        $this->validator->mapFieldsRules([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => [['required'], ['lengthMin', 6]],
            'password_confirmation' => [['required'], ['equals', 'password']],
        ]);
    }

    public function signup(Request $request, Response $response): Response
    {
        return $this->view->render($response, 'auth/signup.php');
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $this->validator = $this->validator->withData($data);

        if (! $this->validator->validate()) {
            return $this->view->render($response, 'auth/signup.php', [
                'errors' => $this->validator->errors(),
                'data' => $data,
            ]);
        }

        return $response;
    }
}
