<?php

declare(strict_types=1);

use App\Controller\UserController;
use App\Middleware\AuthenticationMiddleware;
use Hyperf\HttpServer\Router\Router;


Router::addGroup('/api', function () {

    Router::addGroup('/user', function () {
        Router::post('/register', [UserController::class, 'register']);
        Router::post('/login', [UserController::class, 'login']);
    });
});


Router::get(
    '/test-authenticated',
    [UserController::class, 'testAuthenticated'],
    ['middleware' => [AuthenticationMiddleware::class]]);
