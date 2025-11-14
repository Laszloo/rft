<?php

namespace App\Http\Controllers\Admin;

use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class DashboardController
{
    public function __construct(private readonly PDO $db) {}
    public function index(Request $req, Response $res): Response
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
        $orders = $stmt->fetchAll();

        return Twig::fromRequest($req)->render($res, '/admin/dashboard.html.twig', [
            'title' => 'Dashboard',
            'orders' => $orders
        ]);
    }
}