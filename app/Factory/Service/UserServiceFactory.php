<?php

namespace App\Factory\Service;

use App\Repository\UserRepository;
use App\Service\UserService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class UserServiceFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): UserService
    {
        return new UserService(
            $container->get(UserRepository::class)
        );
    }
}