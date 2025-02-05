<?php

namespace Framework\Http\Controllers\Auth;

use Cartalyst\Sentinel\Sentinel;
use Framework\Validation\Rules\ExistsInDatabase;
use Framework\Views\View;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator;
use Symfony\Component\HttpFoundation\Session\Session;

class RegisterController
{
    public function __construct(protected View $view, protected Sentinel $sentinel, protected Session $session) {}

    public function index(ServerRequestInterface $request)
    {
        $response = new Response();

        $response->getBody()->write(
            $this->view->render('auth/register.twig', [
                'errors' => $this->session->getFlashBag()->get('errors')[0] ?? null
            ])
        );

        return $response;
    }

    public function store(ServerRequestInterface $request)
    {
        try {
            Validator::key('first_name', Validator::alpha()->notEmpty())
                ->key('email', Validator::email()->notEmpty()->not(Validator::existsInDatabase('users', 'email')))
                ->key('password', Validator::notEmpty())
                ->assert($request->getParsedBody());
        } catch (ValidationException $e) {
            $this->session->getFlashBag()->add('errors', $e->getMessages());

            return new Response\RedirectResponse('/register');
        }

        if ($user = $this->sentinel->registerAndActivate($request->getParsedBody())) {
            $this->sentinel->login($user);
        }

        return new Response\RedirectResponse('/dashboard');
    }
}