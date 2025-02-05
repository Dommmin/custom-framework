<?php

namespace Framework\Core;

use League\Container\Container as LeagueContainer;

class Container
{
    protected static $instance;

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new LeagueContainer();
        }

        return static::$instance;
    }
}