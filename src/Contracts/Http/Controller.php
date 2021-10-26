<?php

namespace App\Contracts\Http;

interface Controller
{
    public function call(string $method): Response;
}
