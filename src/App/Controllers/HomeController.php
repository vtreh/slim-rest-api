<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

class HomeController
{
    public function __construct(
        private PhpRenderer $view,
    ) {
    }
    public function __invoke(Request $request, Response $response): Response
    {
        return $this->view->render($response, 'home.php');
    }
}
