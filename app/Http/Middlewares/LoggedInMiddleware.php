<?php

namespace App\Http\Middlewares;

use App\Infrastructure\Middleware\Middleware;
use App\Infrastructure\Middleware\MiddlewareHandler;
use Symfony\Component\HttpFoundation\Request;

class LoggedInMiddleware implements Middleware
{
    /**
     * @inheritDoc
     */
    public function process(Request $request, MiddlewareHandler $handler): mixed
    {
        $session = $request->getSession()->get('opt_id');
        if ($session) {
            header('Location: /profile');
        }

        return $handler->handle($request);
    }
}