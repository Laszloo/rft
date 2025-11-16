<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repository\BookRepository;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class DemoController extends BaseController
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(Request $req, Response $res): Response
    {
        $books = $this->getRepository(BookRepository::class)->getBooks();

        return $this->render($res, 'demo.html.twig', [
            'title' => 'Demo',
            'hello' => 'Hello World!',
            'books' => $books
        ]);
    }
}
