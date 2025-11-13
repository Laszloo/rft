<?php
declare(strict_types=1);

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';
Dotenv\Dotenv::createImmutable(dirname(__DIR__))->safeLoad();

$container = new Container();
AppFactory::setContainer($container);

$container->set(PDO::class, function () {
    $db = require __DIR__ . '/../app/Config/database.php';
    return new PDO($db['dsn'], $db['user'], $db['pass'], $db['options']);
});

$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);


$container->set(Slim\Views\Twig::class, fn() => Slim\Views\Twig::create(__DIR__ . '/../app/Templates', [
    'cache' => false,
]));

$twig = $container->get(Slim\Views\Twig::class);
$app->add(TwigMiddleware::create($app, $twig));


(require __DIR__ . '/../app/Routes/web.php')($app);

$app->run();
