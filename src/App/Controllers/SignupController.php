<?php

declare(strict_types=1);

namespace App\Controllers;

use Slim\Views\PhpRenderer;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class SignupController
{
    public function __construct(
        private PhpRenderer $view,
    ) {
    }

    public function signup(Request $request, Response $response): Response
    {
        return $this->view->render($response, 'auth/signup.php');
    }
}
