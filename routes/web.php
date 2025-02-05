<?php

use Framework\Http\Controllers\Auth\LoginController;
use Framework\Http\Controllers\Auth\LogoutController;
use Framework\Http\Controllers\Auth\RegisterController;
use Framework\Http\Controllers\DashboardController;
use Framework\Http\Controllers\HomeController;
use Framework\Http\Controllers\UserController;
use Framework\Http\Middleware\FlashOldDataMiddleware;
use Framework\Http\Middleware\RedirectIfAuthenticated;
use Framework\Http\Middleware\RedirectIfGuest;
use League\Route\RouteGroup;
use League\Route\Router;
use Psr\Container\ContainerInterface;

return static function (Router $router, ContainerInterface $container) {
    $router->middleware($container->get('csrf'));
    $router->middleware(new FlashOldDataMiddleware());

    $router->get('/', HomeController::class)->setName('home');

    $router->group('/', function (RouteGroup $route) {
        $route->get('/dashboard', DashboardController::class);
        $route->post('/logout', LogoutController::class);
    })->middleware(new RedirectIfGuest());

    $router->group('/', function (RouteGroup $route) {
        $route->get('/register', [RegisterController::class, 'index']);
        $route->post('/register', [RegisterController::class, 'store']);

        $route->get('/login', [LoginController::class, 'index']);
        $route->post('/login', [LoginController::class, 'store']);
    })->middleware(new RedirectIfAuthenticated());


    $router->get('/users/{user}', UserController::class);
};