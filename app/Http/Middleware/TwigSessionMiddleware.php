<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Slim\Views\Twig;

final class TwigSessionMiddleware implements MiddlewareInterface
{
    public function __construct(private Twig $twig) {}

    public function process($request, $handler): ResponseInterface
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $this->twig->getEnvironment()->addGlobal('app', $_SESSION);
        $this->twig->getEnvironment()->addGlobal('user', $_SESSION['user'] ?? null);

        return $handler->handle($request);
    }
}
