<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

class OrderRepository extends Repository
{
    public function getAllOrdersWithUsers(): array
    {
        $stmt = $this->db->query(<<<SQL
        SELECT
            o.id AS order_id,
            o.order_number,
            o.status,
            o.total_gross,
            o.created_at,

            u.id  AS user_id,
            u.name,
            u.email
        FROM orders AS o
        LEFT JOIN users AS u ON o.user_id = u.id
        ORDER BY o.created_at DESC
        SQL);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getOrderDetails(int $orderId): array
    {
        $stmt = $this->db->prepare(<<<SQL
            SELECT
                o.id           AS order_id,
                o.order_number,
                o.status,
                o.total_gross,
                o.created_at,
            
                u.id           AS user_id,
                u.name,
                u.email,
            
                oi.id          AS order_item_id,
                oi.qty,
                oi.unit_price,
                oi.line_total,
            
                b.id           AS book_id,
                b.title,
                b.author,
                b.image_url
            FROM orders AS o
            LEFT JOIN users        AS u  ON o.user_id = u.id
            LEFT JOIN order_items  AS oi ON oi.order_id = o.id
            LEFT JOIN books        AS b  ON b.id = oi.book_id
            WHERE o.id = ?
            ORDER BY o.created_at DESC, oi.id ASC;

        SQL);
        $stmt->execute([$orderId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
