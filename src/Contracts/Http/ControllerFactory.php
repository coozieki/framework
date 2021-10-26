<?php

namespace App\Contracts\Http;

interface ControllerFactory
{
    public function create(string $controller): Controller;
}
