<?php

namespace Framework\Http\Controllers;

use Framework\Models\User;
use Framework\Views\View;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

class UserController
{
    public function __construct(protected View $view) {}

    public function __invoke(ServerRequestInterface $request, array $arguments)
    {
        $user = User::findOrFail($arguments['user']);

        $response = new Response();

        $response->getBody()->write(
            $this->view->render('user.twig', [
                'user' => $user
            ])
        );

        return $response;
    }
}