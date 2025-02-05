<?php

namespace Framework\Http\Controllers;

use Framework\Config\Config;
use Framework\Models\User;
use Framework\Views\View;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

class HomeController
{
    public function __construct(protected Config $config, protected View $view) {}

    public function __invoke(ServerRequestInterface $request)
    {
       return view('home.twig', [
            'name' => $this->config->get('app.name'),
            'users' => User::paginate(1),
        ]);
    }
}