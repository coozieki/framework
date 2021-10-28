<?php

namespace Coozieki\Container;

use Coozieki\Contracts\Container\Container as ContainerInterface;
use Container\Container as PackageContainer;
use Container\UnresolvableBindingException;
use ReflectionException;

class Container implements ContainerInterface
{
    /**
     * @codeCoverageIgnore
     *
     * @param PackageContainer $container
     */
    public function __construct(private PackageContainer $container)
    {
    }

    /**
     * @throws UnresolvableBindingException
     */
    public function singleton(string $abstract, object $concrete): void
    {
        $this->container->singleton($abstract, $concrete);
    }

    public function register(string $abstract, mixed $concrete): void
    {
        $this->container->bind($abstract, $concrete);
    }

    /**
     * @throws UnresolvableBindingException
     * @throws ReflectionException
     */
    public function resolve(string $abstract): mixed
    {
        return $this->container->make($abstract);
    }
}
