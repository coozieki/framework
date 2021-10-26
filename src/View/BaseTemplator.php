<?php

namespace App\View;

use App\Contracts\View\Templator;

class BaseTemplator implements Templator
{
    //TODO: get views directory from configuration
    private string $viewsPath = 'views';

    public function render(string $file, array $params): string
    {
        extract($params, EXTR_OVERWRITE);

        ob_start();
        include $this->viewsPath . '/' . $file . '.php';

        return ob_get_clean();
    }
}
