<?php

namespace Coozieki\Framework\Contracts\View;

interface Templator
{
    public function render(string $file, array $params): string;

    public function configure(array $config): void;
}
