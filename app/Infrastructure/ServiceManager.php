<?php

namespace App\Infrastructure;

use Laminas\ServiceManager\ServiceManager as SM;

/**
 * @method mixed get(string $id)
 * @method mixed has(string $id)
 */
class ServiceManager extends Singleton
{
    private SM $serviceManager;

    protected function __construct()
    {
        $this->serviceManager = new SM(include __DIR__ . '/../../config/service-manager.php');
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return $this->serviceManager->{$name}(...$arguments);
    }
}