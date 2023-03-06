<?php

namespace App\Factory\Repository;

use App\Repository\UserRepository;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class UserRepositoryFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): UserRepository
    {
        return new UserRepository(
            $container->get('em')
        );
    }
}