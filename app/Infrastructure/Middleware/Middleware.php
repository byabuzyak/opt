<?php

namespace App\Infrastructure\Middleware;

use Symfony\Component\HttpFoundation\Request;

interface Middleware
{
    /**
     * @param Request $request
     * @param MiddlewareHandler $handler
     * @return mixed
     */
    public function process(Request $request, MiddlewareHandler $handler): mixed;
}