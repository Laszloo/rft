#!/usr/bin/env php
<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
Dotenv\Dotenv::createImmutable(dirname(__DIR__))->safeLoad();

$host = getenv('MYSQL_HOST');
$db   = getenv('MYSQL_DATABASE');
$user = getenv('MYSQL_USERNAME');
$pass = getenv('MYSQL_PASSWORD');

$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $host, $db);
$pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

echo "Adatbázis teljes reset indul: $db\n";

$tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
if ($tables) {
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0;');
    foreach ($tables as $t) {
        echo "  - Dropping table $t\n";
        $pdo->exec("DROP TABLE IF EXISTS `$t`;");
    }
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1;');
}
echo "Összes tábla törölve.\n";

echo "Migrációk futtatása...\n";
passthru('vendor/bin/phinx migrate -c phinx.php');

echo "Seederek futtatása...\n";
passthru('vendor/bin/phinx seed:run -c phinx.php');

echo "Adatbázis reset befejezve!\n";
