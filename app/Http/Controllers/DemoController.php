<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DemoController
{
    public function index(Request $req, Response $res): Response
    {
        return Twig::fromRequest($req)->render($res, 'demo.html.twig', [
            'title' => 'Demo',
            'hello' => 'Hello World!',
        ]);
    }
}
