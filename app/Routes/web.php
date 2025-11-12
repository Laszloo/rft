<?php
declare(strict_types=1);

use Slim\App;
use App\Http\Controllers\DemoController;

return function (App $app) {
    $app->get('/', [DemoController::class, 'index']);
};