<?php

namespace App\Repository;

use PDO;

abstract class Repository
{
    public function __construct(protected readonly PDO $db) {}
}