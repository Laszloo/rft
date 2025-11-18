<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

class BookRepository extends Repository
{
    public function getBooks(): array
    {
        $stmt = $this->db->query("SELECT * FROM books ORDER BY id DESC");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
