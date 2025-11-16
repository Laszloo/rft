<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App\Config\Application;
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

        $this->messageCheck();

        return $handler->handle($request);
    }


    private function messageCheck(): void {
        if (isset($_SESSION['messages'])) {
            $_SESSION['messages'] = $_SESSION['messages'] = array_filter(
                $_SESSION['messages'],
                fn (array $message) =>
                    $message['time'] + Application::MESSAGES_SHOW_TIME > time()
            );
        }
    }
}
