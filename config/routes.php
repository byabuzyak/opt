<?php

use App\Http\Controllers;
use App\Http\Middlewares\AuthMiddleware;
use App\Http\Middlewares\LoggedInMiddleware;
use App\Infrastructure\Routing\Router;

Router::get(uri: '/', action: [Controllers\IndexController::class, 'index']);

Router::get(uri: '/login', action: [Controllers\LoginController::class, 'get'], middlewares: [
    new LoggedInMiddleware,
]);
Router::post(uri: '/login', action: [Controllers\LoginController::class, 'post'], middlewares: [
    new LoggedInMiddleware,
]);

Router::get(uri: '/profile', action: [Controllers\ProfileController::class, 'index'], middlewares: [
    new AuthMiddleware,
]);

Router::get(uri: '/register', action: [Controllers\RegisterController::class, 'get'], middlewares: [
    new LoggedInMiddleware,
]);
Router::post(uri: '/register', action: [Controllers\RegisterController::class, 'post'], middlewares: [
    new LoggedInMiddleware,
]);

/**
 * It's better to add also a few additional middlewares like throttle middleware
 * But it is beyond the scope of the task
 */
Router::get(uri: '/verify', action: [Controllers\VerifyController::class, 'get'], middlewares: [
    new LoggedInMiddleware,
]);
Router::post(uri: '/verify', action: [Controllers\VerifyController::class, 'post'], middlewares: [
    new LoggedInMiddleware,
]);
