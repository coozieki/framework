<?php

namespace Coozieki\Framework\Contracts\Http;

interface ControllerFactory
{
    public function create(string $controller): Controller;
}
