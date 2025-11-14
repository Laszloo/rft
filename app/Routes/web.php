<?php
declare(strict_types=1);

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\TwigSessionMiddleware;
use App\Http\Middleware\UserMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Slim\Views\Twig;

return function (App $app) {
    $container = $app->getContainer();
    $app->add(new TwigSessionMiddleware($container->get(Twig::class)));

    $app->get('/', [HomeController::class, 'index']);
    $app->get('/404', [HomeController::class, 'notFound']);
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
    $app->group('/admin', function (RouteCollectorProxy $group){
        $group->get('', [DashboardController::class, 'index']);
    })
        ->add(new AdminMiddleware())
        ->add(new UserMiddleware());
};
