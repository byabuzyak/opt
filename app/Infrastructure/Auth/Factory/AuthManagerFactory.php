<?php

namespace App\Infrastructure\Auth\Factory;

use App\Infrastructure\Auth\AuthManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class AuthManagerFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): AuthManager
    {
        return new AuthManager(
            $container->get('request')->getSession()
        );
    }
}