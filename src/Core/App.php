<?php

namespace App\Core;

use App\Contracts\Container\Container;

class App
{
    /**
     * @codeCoverageIgnore
     *
     * @param Container $container
     */
    public function __construct(private Container $container)
    {
    }

    /**
     * @param string $class
     * @return mixed
     */
    public function make(string $class): mixed
    {
        return $this->container->resolve($class);
    }

    public function bind(string $class, mixed $binding): void
    {
        $this->container->register($class, $binding);
    }

    public function singleton(string $class, object $binding): void
    {
        $this->container->singleton($class, $binding);
    }
}
