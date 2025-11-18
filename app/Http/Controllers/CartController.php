<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CartController extends BaseController
{
    public function add(Request $req, Response $res, array $args): Response
    {
        $id = (int)$args['id'];
        $cart = &$this->cart();
        $cart[$id] = ($cart[$id] ?? 0) + 1;
        return $res->withHeader('Location', '/kosar')->withStatus(302);
    }


    public function view(Request $req, Response $res): Response
    {
        $cartData = $this->getCartFromDb();

        return $this->render($res, 'cart/index.html.twig', [
            'title' => 'Kosár',
            'items' => $cartData['items'],
            'total' => $cartData['total'],
        ]);
    }


    public function update(Request $req, Response $res): Response
    {
        $d = (array)$req->getParsedBody();
        $cart = &$this->cart();

        foreach (($d['qty'] ?? []) as $id => $q) {
            $q = max(0, (int)$q);
            if ($q === 0) {
                unset($cart[$id]);
            } else {
                $cart[$id] = $q;
            }
        }
        foreach (($d['remove'] ?? []) as $id) {
            unset($cart[$id]);
        }
        return $res->withHeader('Location', '/kosar')->withStatus(302);
    }


    public function checkout(Request $req, Response $res): Response
    {
        $cart = $this->getCartFromDb();
        if (empty($cart['total'])) {
            return $res->withHeader('Location', '/');
        }

        $this->db->beginTransaction();
        try {
            $sqlOrder = <<<SQL
              INSERT INTO orders
                (user_id, order_number, total_gross, created_at)
              VALUES
                (:user_id, :order_number, :total_gross, NOW())
            SQL;

            $stmt = $this->db->prepare($sqlOrder);
            $transOk = $stmt->execute([
                ':user_id'        => $_SESSION['user']['id'],
                ':order_number'   => time(),
                ':total_gross'    => $cart['total']
            ]);
            $orderId = $this->db->lastInsertId();

            $sqlItem = <<<SQL
              INSERT INTO order_items (order_id, book_id, qty, unit_price, line_total)
              VALUES (:order_id, :book_id, :qty, :unit_price, :line_total)
            SQL;
            $stmtItem = $this->db->prepare($sqlItem);

            $sqlStock = <<<SQL
                UPDATE books SET stock = stock - :qty WHERE id = :book_id AND stock >= :qty
            SQL;
            $stmtStock = $this->db->prepare($sqlStock);
            foreach ($cart['items'] as $item) {
                $transOk = $transOk && $stmtItem->execute([
                    ':order_id'   => $orderId,
                    ':book_id'    => $item['book']['id'],
                    ':qty'        => $item['qty'],
                    ':unit_price' => $item['book']['price'],
                    ':line_total' => $item['sum'],
                ]);

                $transOk = $transOk && $stmtStock->execute([
                    ':qty'     => $item['qty'],
                    ':book_id' => $item['book']['id'],
                ]);
            }
            $transOk = $transOk && $this->db->commit();
            if ($transOk) {
                $this->resetCart();
                return $this->render($res, 'cart/checkout.html.twig', [
                    'title' => 'Fizetés (demo)',
                    'message' => 'Sikeres fizetés',
                    'orderId' => $orderId,
                ]);
            }
            //log message kéne
        } catch (\Throwable $t) {
            $this->db->rollBack();
            //log message kéne
        }

        return $this->render($res, 'cart/checkout.html.twig', [
            'title' => 'Fizetés (demo)',
            'message' => 'Sikertelen fizetés'
        ]);
    }


    private function &cart(): array
    {
        $_SESSION['cart'] ??= [];

        return $_SESSION['cart'];
    }


    private function resetCart(): void
    {
        $_SESSION['cart'] = [];
    }


    private function getCartFromDb(): array
    {
        $cart = $this->cart();
        $items = [];
        $total = 0;

        if ($cart) {
            $ids = implode(',', array_map('intval', array_keys($cart)));
            $rows = $this->db->query("SELECT id, title, author, price, image_url FROM books WHERE id IN ($ids)")
                ->fetchAll();
            foreach ($rows as $row) {
                $qty = $cart[$row['id']] ?? 0;
                $sum = $qty * (float)$row['price'];
                $total += $sum;
                $items[] = ['book' => $row, 'qty' => $qty, 'sum' => $sum];
            }
        }

        return ['items' => $items, 'total' => $total];
    }
}
