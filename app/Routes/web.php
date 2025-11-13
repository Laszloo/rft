<?php
declare(strict_types=1);

use App\Http\Controllers\HomeController;
use Slim\App;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\CartController;

return function (App $app) {
     $app->add(function ($req, $handler) {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        return $handler->handle($req);
    });
    $app->get('/', [HomeController::class, 'index']);
    $app->get('/demo', [DemoController::class, 'index']);

    //  Kosár
    $app->post('/kosar/hozzaad/{id}', [CartController::class, 'add']);
    $app->get('/kosar', [CartController::class, 'view']);
    $app->post('/kosar/frissit', [CartController::class, 'update']);
    $app->get('/fizetes', [CartController::class, 'checkout']);
};
