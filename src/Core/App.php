<?php

namespace Coozieki\Framework\Core;

use Coozieki\Framework\Contracts\Container\Container;
use Coozieki\Framework\Contracts\View\Templator;
use Coozieki\Framework\Exceptions\ConfigurationException;

class App
{
    public static self $instance;

    private string $basePath;

    /**
     * @codeCoverageIgnore
     *
     * @param Container $container
     */
    public function __construct(private Container $container)
    {
        $this->basePath = getcwd();
        self::$instance = $this;
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

    /**
     * @throws ConfigurationException
     */
    public function setTemplatorClass(string $templator): void
    {
        if (!is_subclass_of($templator, Templator::class)) {
            throw new ConfigurationException('Custom Templator class must be instance of ' . Templator::class);
        }
        $this->container->singleton(Templator::class, $this->container->resolve($templator));
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }

    public function setBasePath(string $basePath): void
    {
        $this->basePath = $basePath;
    }
}
