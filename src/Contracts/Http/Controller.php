<?php

namespace App\Contracts\Http;

interface Controller
{
    public function call(ResponseFactory $responseFactory, string $method): Response;
}
