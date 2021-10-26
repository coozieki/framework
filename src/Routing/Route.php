<?php

namespace App\Routing;

use App\Contracts\Routing\Route as RouteInterface;

class Route implements RouteInterface
{
    /**
     * @codeCoverageIgnore
     * @param string $uri
     * @param string $controller
     * @param string $controllerMethod
     * @param string $httpMethod
     */
    public function __construct(
        private string $uri,
        private string $controller,
        private string $controllerMethod,
        private string $httpMethod
    ) {
    }

    /**
     * @var string|null
     */
    private $name;

    public static function get(string $uri, array $controllerParams): static
    {
        return new static($uri, $controllerParams[0], $controllerParams[1], 'GET');
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getControllerMethod(): string
    {
        return $this->controllerMethod;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
