<?php

namespace Coozieki\Framework\View;

use Coozieki\Framework\Support\File;

class SimpleTemplator extends BaseTemplator
{
    public function __construct(private File $file)
    {
    }

    public function render(string $file, array $params): string
    {
        extract($params, EXTR_OVERWRITE);

        return $this->file->requireAsText($this->getFullPath($file));
    }
}
