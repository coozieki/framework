<?php

namespace Coozieki\Framework\Contracts\Http;

interface Controller
{
    public function call(string $method): Response;
}
