<?php
require __DIR__ . '/vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__)->safeLoad();

$host = getenv('MYSQL_HOST');
$db   = getenv('MYSQL_DATABASE');
$user = getenv('MYSQL_USERNAME');
$pass = getenv('MYSQL_PASSWORD');

return [
    'paths' => [
        'migrations' => 'app/Database/migrations',
        'seeds'      => 'app/Database/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'dev',
        'dev' => [
            'adapter' => 'mysql',
            'host'    => $host,
            'name'    => $db,
            'user'    => $user,
            'pass'    => $pass,
            'port'    => 3306,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci'
        ],
    ],
    'version_order' => 'creation'
];
