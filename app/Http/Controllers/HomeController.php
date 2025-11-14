<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use PDO;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController
{
    public function __construct(private readonly PDO $db) {}

    public function index(Request $req, Response $res): Response
    {
        $stmt = $this->db->query("SELECT id, title, author, image_url, price, stock FROM books ORDER BY id DESC");
        $books = $stmt->fetchAll();

        return Twig::fromRequest($req)->render($res, 'home/index.html.twig', [
            'title' => 'Főoldal',
            'books' => $books,
        ]);
    }


    public function notFound(Request $req, Response $res): Response
    {
        return Twig::fromRequest($req)->render($res, '404.html.twig', [
            'title' => '404'
        ]);
    }
}
