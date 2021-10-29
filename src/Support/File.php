<?php

namespace Coozieki\Framework\Support;

class File
{
    public function requireAsArray(string $filePath): array
    {
        return require $filePath;
    }

    public function requireAsText(string $filePath): string
    {
        ob_start();
        include $filePath;

        return ob_get_clean();
    }
}
