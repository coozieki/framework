<?php

namespace Coozieki\Contracts\Http;

interface ControllerFactory
{
    public function create(string $controller): Controller;
}
