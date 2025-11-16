<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Repository\OrderRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DashboardController extends BaseController
{
    public function index(Request $req, Response $res): Response
    {
        $orders = $this->getRepository(OrderRepository::class)->getAllOrdersWithUsers();

        return $this->render($res, '/admin/dashboard.html.twig', [
            'title' => 'Dashboard',
            'orders' => $orders
        ]);
    }
}
