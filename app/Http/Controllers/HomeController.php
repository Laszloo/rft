<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repository\BookRepository;
use PDO;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController extends BaseController
{
    public function index(Request $req, Response $res): Response
    {
        $books = $this->getRepository(BookRepository::class)->getBooks();

        return $this->render($res, 'home/index.html.twig', [
            'title' => 'Főoldal',
            'books' => $books,
        ]);
    }


    public function notFound(Request $req, Response $res): Response
    {
        return $this->render($res, '404.html.twig', [
            'title' => '404'
        ]);
    }
}
