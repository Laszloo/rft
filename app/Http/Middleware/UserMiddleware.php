<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class UserMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!empty($_SESSION['user'])) {
            return $handler->handle($request);
        }

        $redirectTarget = urlencode((string)$request->getUri());

        $response = new Response();
        return $response
            ->withHeader('Location', '/bejelentkezes?redirect=' . $redirectTarget)
            ->withStatus(302);
    }
}
