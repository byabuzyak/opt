<?php

namespace App\Infrastructure\Routing;

use App\Infrastructure\Middleware\MiddlewareHandler;
use App\Infrastructure\Routing\Exception\HttpNotFoundException;
use App\Infrastructure\ServiceManager;
use Symfony\Component\HttpFoundation\Request;

final class Router
{
    public function __construct(private readonly Request $request)
    {
    }

    /**
     * @var Route[]
     */
    private static array $routes = [];

    /**
     * @param string $routes
     * @return int
     */
    public function register(string $routes): int
    {
        return require $routes;
    }

    /**
     * @param string $uri
     * @param array $action
     * @param array $middlewares
     * @return void
     */
    public static function get(string $uri, array $action, array $middlewares = []): void
    {
        self::addRoute('GET', $uri, $action, $middlewares);
    }

    /**
     * @param string $uri
     * @param array $action
     * @param array $middlewares
     * @return void
     */
    public static function post(string $uri, array $action, array $middlewares = []): void
    {
        self::addRoute('POST', $uri, $action, $middlewares);
    }

    /**
     * It's better to add some validation of routes
     * But it is beyond the scope of the task
     *
     * @param string $method
     * @param string $uri
     * @param array $action
     * @param array $middleware
     * @return void
     */
    public static function addRoute(string $method, string $uri, array $action, array $middleware = []): void
    {
        self::$routes[] = new Route(
            uri: $uri,
            method: $method,
            action: $action,
            middlewares: $middleware
        );
    }

    /**
     * @return void
     * @throws HttpNotFoundException
     * @throws \ReflectionException
     */
    public function serve(): void
    {
        $uri = strtok($this->request->getRequestUri(), '?');
        $method = $this->request->getMethod();
        $route = array_values(
            array_filter(
                self::$routes,
                function (Route $route) use ($method, $uri) {
                    return $route->getMethod() === $method && $route->getUri() === $uri;
                }
            )
        );

        if (empty($route)) {
            throw new HttpNotFoundException(sprintf('No route for uri %s', $uri));
        }

        /** @var Route $route */
        $route = $route[0];
        $action = $route->getAction();
        list($controller, $action) = $action;
        $dependencies = $this->resolveDependencies($controller);
        $middlewareHandler = new MiddlewareHandler(
            static function () use ($action, $dependencies, $controller) {
                $instance = new $controller(...$dependencies);

                return $instance->{$action}();
            },
            ...$route->getMiddlewares()
        );

        $middlewareHandler->handle($this->request);
    }

    /**
     * @param string $class
     * @return array
     * @throws \ReflectionException
     */
    private function resolveDependencies(string $class): array
    {
        $dependencies = [];
        $reflector = new \ReflectionClass($class);
        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            return [];
        }

        foreach ($constructor->getParameters() as $parameter) {
            $class = $parameter->getType()->getName();
            if (is_null($class)) {
                return [];
            }

            $dependencies[] = ServiceManager::i()->has($class) ?
                ServiceManager::i()->get($class) : new $class(...$this->resolveDependencies($class));
        }

        return $dependencies;
    }
}