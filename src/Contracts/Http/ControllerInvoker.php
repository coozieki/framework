<?php

namespace App\Contracts\Http;

interface ControllerInvoker
{
    public function invoke(string $controller, string $method): Response;
}
