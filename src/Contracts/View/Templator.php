<?php

namespace Coozieki\Contracts\View;

interface Templator
{
    public function render(string $file, array $params): string;
}
