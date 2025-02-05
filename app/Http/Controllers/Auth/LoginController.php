<?php

namespace Framework\Http\Controllers\Auth;

use Cartalyst\Sentinel\Sentinel;
use Framework\Views\View;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginController
{
    public function __construct(protected View $view, protected Sentinel $sentinel, protected Session $session) {}

    public function index(ServerRequestInterface $request): Response
    {
        $response = new Response();

        $response->getBody()->write(
            $this->view->render('auth/login.twig', [
                'errors' => $this->session->getFlashBag()->get('errors')[0] ?? null
            ])
        );

        return $response;
    }

    public function store(ServerRequestInterface $request): RedirectResponse
    {
        try {
            Validator::key('email', Validator::email()->notEmpty())
                ->key('password', Validator::notEmpty())
                ->assert($request->getParsedBody());
        } catch (ValidationException $e) {
            $this->session->getFlashBag()->add('errors', $e->getMessages());

            return new RedirectResponse('/login');
        }


        if (!$this->sentinel->authenticate($request->getParsedBody())) {
            $this->session->getFlashBag()->add('errors', [
                'credentials' => 'The provided credentials do not match our records.'
            ]);

            return new RedirectResponse('/login');
        }

        return new RedirectResponse('/dashboard');
    }
}