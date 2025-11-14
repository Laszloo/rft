<?php

namespace App\Http\Controllers\Admin;

use App\Config\Application;
use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class OrdersController
{
    public function __construct(private readonly PDO $db) {}
    public function index(Request $req, Response $res): Response
    {
        if ($req->getMethod() === 'POST') {
            $this->saveStatus($req);
        }
        
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
        $stmt->execute([ $req->getAttribute('id')]);
        $rows = $stmt->fetchAll();

        $first = $rows[0];
        $order = [
            'order_id' => (int)$first['order_id'],
            'order_number' => $first['order_number'],
            'status' => $first['status'],
            'total_gross' => $first['total_gross'],
            'created_at' => $first['created_at'],
            'user_id' => (int)$first['user_id'],
            'name' => $first['name'],
            'email' => $first['email'],
        ];

        $itemRows = array_filter($rows, fn (array $row) => $row['order_item_id'] !== null);
        $orderItems = array_map(
            fn (array $row) => [
                'order_item' => [
                    'id' => (int) $row['order_item_id'],
                    'order_id' => (int) $row['order_id'],
                    'qty' => (int) $row['qty'],
                    'unit_price' => $row['unit_price'],
                    'line_total' => $row['line_total'],
                ],
                'book' => [
                    'id' => (int) $row['book_id'],
                    'title' => $row['title'],
                    'author' => $row['author'],
                    'image_url' => $row['image_url'],
                ],
            ],
            $itemRows
        );

        return Twig::fromRequest($req)->render($res, '/admin/order.html.twig', [
            'title' => 'Megrendelések',
            'order' => $order,
            'order_items' => $orderItems,
            'status' => Application::STATUS,
        ]);
    }

    private function saveStatus(Request $request): bool
    {
        $data = ($request->getParsedBody());
        if (in_array($data['status'], array_keys(Application::STATUS))) {
            $stmt = $this->db->prepare(
                'UPDATE orders 
             SET status = :status, updated_at = NOW() 
             WHERE id = :id'
            );
            $transOk = $stmt->execute([
                ':status' => $data['status'],
                ':id'     => $request->getAttribute('id'),
            ]);

            if ($transOk) {
                $_SESSION["message"][] = "Sikeres mentés!";
                return true;
            }
            $_SESSION["message"][] = "Hiba a mentés során!";
            //logolni kellene
            return false;
        }
        $_SESSION["message"][] = "Nem létező státusz!";
        //logolni kellene

        return false;
    }
}