<?php

$host = getenv('MYSQL_HOST');
$db   = getenv('MYSQL_DATABASE');
$user = getenv('MYSQL_USERNAME');
$pass = getenv('MYSQL_PASSWORD');

return [
    'dsn'  => sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $host, $db),
    'user' => $user,
    'pass' => $pass,
    'options' => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ],
];
