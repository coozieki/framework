<?php

namespace Coozieki\Framework\View;

use Coozieki\Framework\Contracts\View\Templator;
use Coozieki\Framework\Support\File;

abstract class BaseTemplator implements Templator
{
    protected string $viewsPath = 'views';

    protected string $basePath = '.';

    public function __construct(protected File $file)
    {
    }

    protected function getFullPath(string $file): string
    {
        return $this->file->formatPath($this->getFullViewsPath().'/'.$file);
    }

    protected function getFullViewsPath(): string
    {
        return $this->file->formatPath($this->basePath.'/'.$this->viewsPath);
    }

    public function configure(array $config): void
    {
        $this->viewsPath = $config['viewsPath'] ?? $this->viewsPath;
        $this->basePath = $config['basePath'] ?? $this->basePath;
    }
}
