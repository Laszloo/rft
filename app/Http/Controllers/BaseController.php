<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Config\Application;
use App\Repository\Repository;
use InvalidArgumentException;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

abstract class BaseController
{
    private array $messages = [];
    private array $repositories = [];

    public function __construct(
        protected Twig $twig,
        protected readonly PDO $db
    ) {
    }

    /**
     * @template T of Repository
     * @param class-string<T> $repositoryClassname
     * @return T
     */
    protected function getRepository(string $repositoryClassname): Repository
    {
        if (array_key_exists($repositoryClassname, $this->repositories)) {
            return $this->repositories[$repositoryClassname];
        }
        if (class_exists($repositoryClassname)) {
            $repository = new $repositoryClassname($this->db);
            if ($repository instanceof Repository) {
                $this->repositories[$repositoryClassname] = $repository;

                return $this->repositories[$repositoryClassname];
            }
        }

        throw new InvalidArgumentException("Nem létező repository!");
    }


    protected function addMessage(string $type, string $message): bool
    {
        if (array_key_exists($type, Application::MESSAGES_TYPES)) {
            $this->messages[] = ['type' => $type, 'text' => $message];

            return true;
        }

        return false;
    }


    protected function addSessionMessage(string $type, string $message): bool
    {
        if (array_key_exists($type, Application::MESSAGES_TYPES)) {
            $_SESSION['messages'][] = ['type' => $type, 'text' => $message, 'time' => time()];

            return true;
        }

        return false;
    }


    protected function render(
        ResponseInterface $response,
        string $template,
        array $data = []
    ): ResponseInterface {
        return $this->twig->render($response, $template, [
            "messages" => $this->messages,
            ...$data
        ]);
    }
}
