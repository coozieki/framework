<?php

namespace Coozieki\View;

use Coozieki\Contracts\View\Templator;

class BaseTemplator implements Templator
{
    //TODO: get views directory from configuration
    private string $viewsPath = 'views';

    public function render(string $file, array $params): string
    {
        extract($params, EXTR_OVERWRITE);

        ob_start();
        include $this->getFullPath($file);

        return ob_get_clean();
    }

    protected function getFullPath(string $file): string
    {
        return $this->viewsPath . '/' . $file . '.php';
    }
}
