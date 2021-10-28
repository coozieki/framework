<?php

namespace Coozieki\Contracts\Http;

interface Controller
{
    public function call(string $method): Response;
}
