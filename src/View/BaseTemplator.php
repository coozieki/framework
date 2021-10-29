<?php

namespace Coozieki\Framework\View;

use Coozieki\Framework\Contracts\View\Templator;
use Coozieki\Framework\Support\File;

class BaseTemplator implements Templator
{
    //TODO: get views directory from configuration
    protected string $viewsPath = 'views';

    public function __construct(private File $file)
    {
    }

    public function render(string $file, array $params): string
    {
        extract($params, EXTR_OVERWRITE);

        return $this->file->requireAsText($this->getFullPath($file));
    }

    protected function getFullPath(string $file): string
    {
        return $this->viewsPath . '/' . $file . '.php';
    }
}
