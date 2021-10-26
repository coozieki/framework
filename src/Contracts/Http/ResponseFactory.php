<?php

namespace App\Contracts\Http;

interface ResponseFactory
{
    public function html(string $html): Response;

    public function redirect(): Response;
}
