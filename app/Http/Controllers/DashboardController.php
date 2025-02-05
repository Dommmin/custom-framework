<?php

namespace Framework\Http\Controllers;

use Cartalyst\Sentinel\Sentinel;
use Framework\Views\View;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequest;

class DashboardController
{
    public function __construct(protected View $view, protected Sentinel $sentinel) {}

    public function __invoke(ServerRequest $request)
    {
        $response = new Response();

        $response->getBody()->write(
            $this->view->render('dashboard.twig')
        );

        return $response;
    }
}