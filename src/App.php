<?php

namespace App;

use App\Contracts\Container;

class App
{
    public function __construct(private Container $container)
    {
    }

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
