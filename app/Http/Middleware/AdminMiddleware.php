<?php

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class AdminMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($_SESSION['user']['is_admin'] === true) {
            return $handler->handle($request);
        }

        $redirectTarget = urlencode((string)$request->getUri());

        $response = new Response();
        return $response
            ->withHeader('Location', '/404')
            ->withStatus(302);
    }
}
