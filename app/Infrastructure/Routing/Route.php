<?php

namespace App\Infrastructure\Routing;

final readonly class Route
{
    /**
     * @param string $uri
     * @param string $method
     * @param array $action
     * @param array $middlewares
     */
    public function __construct(
        private string $uri,
        private string $method,
        private array $action,
        private array $middlewares = []
    ) {
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getAction(): array
    {
        return $this->action;
    }

    /**
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}