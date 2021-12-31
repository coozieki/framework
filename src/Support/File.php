<?php

namespace Coozieki\Framework\Support;

use Coozieki\Framework\Exceptions\FileNotFoundException;

class File
{
    /**
     * @throws FileNotFoundException
     */
    public function requireAsArray(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw new FileNotFoundException("File at path \"$filePath\" doesn't exist.");
        }
        return require $filePath;
    }

    public function requireAsText(string $filePath): string
    {
        ob_start();
        include $filePath;

        return ob_get_clean();
    }
}
