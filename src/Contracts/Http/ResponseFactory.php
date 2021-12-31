<?php

namespace Coozieki\Framework\Contracts\Http;

interface ResponseFactory
{
    public function html(string $html): Response;

    public function json(mixed $data): Response;

    public function redirect(string $location, ?int $code): Response;

    public function serverError(): Response;

    public function notFound(): Response;
}
