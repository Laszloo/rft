<?php
declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Middleware\UserMiddleware;
use Slim\App;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use Slim\Views\Twig;
use App\Http\Middleware\TwigSessionMiddleware;

return function (App $app) {
    $container = $app->getContainer();
    $app->add(new TwigSessionMiddleware($container->get(Twig::class)));

    $app->get('/', [HomeController::class, 'index']);
    $app->get('/demo', [DemoController::class, 'index']);

    //  Kosár
    $app->post('/kosar/hozzaad/{id}', [CartController::class, 'add']);
    $app->get('/kosar', [CartController::class, 'view']);
    $app->post('/kosar/frissit', [CartController::class, 'update']);
    $app->get('/fizetes', [CartController::class, 'checkout'])->add((new UserMiddleware()));

    //Auth - todo: még a registration form
    $app->map(['GET','POST'], '/bejelentkezes', [AuthController::class, 'login']);
    $app->get('/kijelentkezes', [AuthController::class, 'logout']);

    // Admin
    $app->get('/admin', [DemoController::class, 'index']);
};
