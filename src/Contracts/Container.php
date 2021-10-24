<?php

namespace App\Contracts;

interface Container
{
    public function singleton(string $abstract, object $concrete): void;

    public function register(string $abstract, mixed $concrete): void;

    public function resolve(string $abstract): mixed;
}