<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class DemoController
{
    public function __construct(private readonly \PDO $db) {}

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(Request $req, Response $res): Response
    {
        $stmt = $this->db->query('SELECT * FROM books');
        $books = $stmt->fetchAll();


        return Twig::fromRequest($req)->render($res, 'demo.html.twig', [
            'title' => 'Demo',
            'hello' => 'Hello World!',
            'books' => $books    
        ]);
    }
}
