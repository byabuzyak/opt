<?php

namespace App;

use App\Infrastructure\Routing\Exception\HttpNotFoundException;
use App\Infrastructure\Routing\Router;
use App\Infrastructure\ServiceManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

final class App
{
    /**
     * @var Router
     */
    private Router $router;

    /**
     * @var Request
     */
    private Request $request;

    public function __construct()
    {
        $this->initSession();
        $this->initRoutes();
    }

    /**
     * @return void
     */
    private function initSession(): void
    {
        /** @var Request $request */
        $this->request = ServiceManager::i()->get('request');
        $session = new Session();
        $session->start();
        $this->request->setSession($session);
    }

    /**
     * @return void
     */
    private function initRoutes(): void
    {
        $this->router = new Router(
            $this->request
        );
        $this->router->register(__DIR__ . '/../config/routes.php');
    }

    /**
     * @throws HttpNotFoundException
     * @throws \ReflectionException
     */
    public function run(): void
    {
        $this->router->serve();
    }
}