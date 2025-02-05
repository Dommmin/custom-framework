<?php

namespace Framework\Views;

use Cartalyst\Sentinel\Sentinel;
use Framework\Config\Config;
use Psr\Container\ContainerInterface;
use Slim\Csrf\Guard;
use Symfony\Component\HttpFoundation\Session\Session;
use Twig\Extension\AbstractExtension;

class TwigRuntimeExtension extends AbstractExtension
{
    public function __construct(protected ContainerInterface $container) {}

    public function config(): Config
    {
        return app(Config::class);
    }

    public function auth(): Sentinel
    {
        return app(Sentinel::class);
    }

    public function session(): Session
    {
        return app(Session::class);
    }

    public function old(string $key)
    {
        return $this->session()->getFlashBag()->peek('old')[$key] ?? null;
    }

    public function csrf(): string
    {
        /** @var Guard $guard */
        $guard = app('csrf');

        return '
            <input type="hidden" name="' . $guard->getTokenNameKey() . '" value="' . $guard->getTokenName() . '">
            <input type="hidden" name="' . $guard->getTokenValueKey() . '" value="' . $guard->getTokenValue() . '">
        ';
    }

    public function route(string $name, array $arguments = []): string
    {
        return route($name, $arguments);
    }

    public function vite(): string
    {
        return vite();
    }
}