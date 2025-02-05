<?php

namespace Framework\Providers;

use Framework\Config\Config;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Spatie\Ignition\Ignition;
use Symfony\Component\HttpFoundation\Session\Session;

class SessionServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{

    public function boot(): void
    {
        //
    }

    public function register(): void
    {
        $this->getContainer()->add(Session::class, function () {
            return new Session();
        })->setShared();
    }

    public function provides(string $id): bool
    {
        $services = [
            Session::class,
        ];

        return in_array($id, $services);
    }
}