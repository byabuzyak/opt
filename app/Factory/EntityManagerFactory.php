<?php

namespace App\Factory;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\ORMSetup;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class EntityManagerFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     * @throws MissingMappingDriverImplementation
     * @throws Exception
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): EntityManager
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: array(__DIR__ . "/src"),
        );

        return new EntityManager(
            DriverManager::getConnection([
                'driver' => 'pdo_mysql',
                'host' => 'mysql',
                'charset' => 'utf8',
                'user' => 'root',
                'password' => '',
                'dbname' => 'opt',
            ], $config),
            $config
        );
    }
}