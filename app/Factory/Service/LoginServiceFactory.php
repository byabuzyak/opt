<?php

namespace App\Factory\Service;

use App\Infrastructure\Auth\AuthManager;
use App\Repository\UserRepository;
use App\Service\LoginService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class LoginServiceFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): LoginService
    {
        return new LoginService(
            $container->get(UserRepository::class),
            $container->get(AuthManager::class),
        );
    }
}