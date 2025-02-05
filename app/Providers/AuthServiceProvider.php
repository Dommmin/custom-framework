<?php

namespace Framework\Providers;

use Cartalyst\Sentinel\Native\SentinelBootstrapper;
use Cartalyst\Sentinel\Sentinel;
use Framework\Config\Config;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class AuthServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    protected Sentinel $sentinel;

    public function boot(): void
    {
        $bootstrapper = new SentinelBootstrapper($this->container->get(Config::class)->get('auth'));

        $this->sentinel = $bootstrapper->createSentinel();
    }

    public function register(): void
    {
        $this->getContainer()->add(Sentinel::class, function () {
            return $this->sentinel;
        })->setShared();
    }

    public function provides(string $id): bool
    {
        $services = [
            Sentinel::class,
        ];

        return in_array($id, $services);
    }
}