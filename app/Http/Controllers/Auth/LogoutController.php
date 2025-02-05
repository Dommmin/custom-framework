<?php

namespace Framework\Http\Controllers\Auth;

use Cartalyst\Sentinel\Sentinel;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class LogoutController
{
    public function __construct(protected Sentinel $sentinel, protected Session $session) {}

    public function __invoke(ServerRequestInterface $request)
    {
        $this->sentinel->logout();

        $this->session->getFlashBag()->add('message', 'You have been logged out.');

        return new Response\RedirectResponse('/');
    }
}