<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

abstract class Repository
{
    public function __construct(protected readonly PDO $db)
    {
    }
}
