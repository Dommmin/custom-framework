<?php

namespace Framework\Providers;

use Laminas\Diactoros\Request;
use Laminas\Diactoros\ServerRequestFactory;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class RequestServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{

    public function boot(): void
    {
    }

    public function register(): void
    {
        $this->container->add(Request::class, function () {
            return ServerRequestFactory::fromGlobals(
                $_SERVER,
                $_GET,
                $_POST,
                $_COOKIE,
                $_FILES
            );
        })->setShared();
    }

    public function provides(string $id): bool
    {
        $services = [
            Request::class,
        ];

        return in_array($id, $services);
    }
}