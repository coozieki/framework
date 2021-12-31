<?php

namespace Coozieki\Framework\View;

use Coozieki\Framework\Contracts\View\Templator;

abstract class BaseTemplator implements Templator
{
    protected string $viewsPath = 'views';

    protected function getFullPath(string $file): string
    {
        return $this->viewsPath . '/' . $file;
    }

    public function configure(array $config): void
    {
        if (isset($config['viewsPath'])) {
            $this->viewsPath = $config['viewsPath'];
        }
    }
}
