<?php

namespace tests\Unit\TestClasses;

use Coozieki\Contracts\View\Templator;

class TemplatorExample implements Templator
{
    public function render(string $file, array $params): string
    {
        // TODO: Implement render() method.
    }
}
