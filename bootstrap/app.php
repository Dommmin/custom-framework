<?php

use Dotenv\Dotenv;
use Framework\Config\Config;
use Framework\Core\App;
use Framework\Core\Container;
use Framework\Providers\ConfigServiceProvider;
use League\Container\ReflectionContainer;

error_reporting(0);

require '../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$container = Container::getInstance();
$container->delegate(new ReflectionContainer());
$container->addServiceProvider(new ConfigServiceProvider());

$config = $container->get(Config::class);

foreach ($config->get('app.providers') as $provider) {
    $container->addServiceProvider(new $provider);
}

$app = new App($container);

(require('../routes/web.php'))($app->getRouter(), $container);

$app->run();