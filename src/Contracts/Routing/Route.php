<?php

namespace Coozieki\Contracts\Routing;

interface Route
{
    public static function get(string $uri, array $controllerParams): static;

    public function getName(): ?string;

    public function getHttpMethod(): string;

    public function getController(): string;

    public function getControllerMethod(): string;

    public function getUri(): string;

    public function name(string $name): static;
}
