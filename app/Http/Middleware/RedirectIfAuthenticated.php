<?php

namespace Framework\Http\Middleware;

use Cartalyst\Sentinel\Sentinel;
use Framework\Core\Container;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class RedirectIfAuthenticated implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $container = Container::getInstance();

        if ($container->get(Sentinel::class)->check()) {
            $container->get(Session::class)->getFlashBag()->add('message', 'You are already logged in.');
            return new RedirectResponse('/');
        }

        return $handler->handle($request);
    }
}