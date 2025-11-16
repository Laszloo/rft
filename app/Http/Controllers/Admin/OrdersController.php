<?php

namespace App\Http\Controllers\Admin;

use App\Config\Application;
use App\Http\Controllers\BaseController;
use App\Repository\OrderRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class OrdersController extends BaseController
{
    public function index(Request $req, Response $res): Response
    {
        if ($req->getMethod() === 'POST') {
            if($this->saveStatus($req)) {
                return $res->withHeader('Location', '/admin/rendeles/34')->withStatus(302);
            }
        }

        $orderRows = $this->getRepository(OrderRepository::class)
            ->getOrderDetails($req->getAttribute('id'));

        $first = $orderRows[0];
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

        $itemRows = array_filter($orderRows, fn (array $row) => $row['order_item_id'] !== null);
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

        return $this->render($res, '/admin/order.html.twig', [
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
                $this->addSessionMessage('success', 'Sikeres mentés!');

                return true;
            }
            $this->addSessionMessage('error', 'Sikertelen mentés!');
            //logolni kellene
            return false;
        }
        $this->addSessionMessage('error', 'Nem létező státusz!');
        //logolni kellene

        return false;
    }
}
