<?php

namespace App\Infrastructure\Middleware;

use Symfony\Component\HttpFoundation\Request;

/**
 * The base implementation of HTTP middlewares
 * Ideally we should implement work with Response object instead of
 * work if Closure
 * For example: PSR-7 ResponseInterface, but it stands out of the requirements
 */
class MiddlewareHandler
{
    /**
     * @var Middleware[]
     */
    protected array $middlewares = [];

    /**
     * @var \Closure
     */
    protected \Closure $response;

    public function __construct(\Closure $response, Middleware ...$middlewares)
    {
        $this->response = $response;
        $this->middlewares = $middlewares;
    }

    /**
     * @param Middleware $middleware
     * @return MiddlewareHandler
     */
    private function withoutMiddleware(Middleware $middleware): MiddlewareHandler
    {
        return new self(
            $this->response,
            ...array_filter(
                $this->middlewares,
                function ($m) use ($middleware) {
                    return $middleware !== $m;
                }
            )
        );
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function handle(Request $request): mixed
    {
        $middleware = $this->middlewares[0] ?? false;
        if (!$middleware) {
            return ($this->response)();
        }

        return $middleware->process(
            $request,
            $this->withoutMiddleware($middleware)
        );
    }
}