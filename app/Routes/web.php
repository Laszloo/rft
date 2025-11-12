<?php
declare(strict_types=1);

use App\Http\Controllers\HomeController;
use Slim\App;
use App\Http\Controllers\DemoController;

return function (App $app) {
    $app->get('/', [HomeController::class, 'index']);
    $app->get('/demo', [DemoController::class, 'index']);
};
