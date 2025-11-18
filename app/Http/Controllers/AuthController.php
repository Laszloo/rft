<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController extends BaseController
{
    public function login(Request $req, Response $res): Response
    {
        if ($req->getMethod() === 'POST') {
            $data = (array)$req->getParsedBody();
            $email = trim($data['email'] ?? '');
            $pass  = (string)($data['password'] ?? '');

            $stmt = $this->db->prepare("SELECT id, name, email, password_hash, is_admin FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($pass, $user['password_hash'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'is_admin' => (bool)$user['is_admin'],
                ];
                $to = $user['is_admin'] ? '/admin' : '/';

                return $res->withHeader('Location', $to)->withStatus(302);
            }

            return $this->render($res, 'auth/login.html.twig', [
                'title' => 'Bejelentkezés',
                'error' => 'Hibás e-mail vagy jelszó.',
            ]);
        }

        return $this->render($res, 'auth/login.html.twig', [
            'title' => 'Bejelentkezés',
        ]);
    }


    public function logout(Request $req, Response $res): Response
    {
        unset($_SESSION['user']);

        return $res->withHeader('Location', '/')->withStatus(302);
    }
}
