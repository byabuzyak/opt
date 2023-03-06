<?php

return [
    'services' => [

    ],
    'invokables' => [
        \App\Infrastructure\Validator\Validator::class => \App\Infrastructure\Validator\Validator::class,

    ],
    'factories' => [
        \App\Service\LoginService::class => \App\Factory\Service\LoginServiceFactory::class,
        \App\Service\UserService::class => \App\Factory\Service\UserServiceFactory::class,
        \Doctrine\ORM\EntityManager::class => \App\Factory\EntityManagerFactory::class,
        \App\Infrastructure\Auth\AuthManager::class => \App\Infrastructure\Auth\Factory\AuthManagerFactory::class,
        \Symfony\Component\HttpFoundation\Request::class => \App\Factory\RequestFactory::class,
        \App\Repository\UserRepository::class => \App\Factory\Repository\UserRepositoryFactory::class,
    ],
    'abstract_factories' => [
    ],
    'delegators' => [

    ],
    'aliases' => [
        'em' => \Doctrine\ORM\EntityManager::class,
        'request' => \Symfony\Component\HttpFoundation\Request::class,
    ],
    'initializers' => [

    ],
    'lazy_services' => [

    ],
    'shared' => [

    ],
    'shared_by_default' => true,
];