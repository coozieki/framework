<?php

namespace App\Contracts\Http;

interface ResponseFactory
{
    public function html(string $html): Response;

    public function redirect(): Response;

    public function serverError(): Response;

    public function notFound(): Response;
}
