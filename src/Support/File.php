<?php

namespace Coozieki\Framework\Support;

use Coozieki\Framework\Exceptions\FileNotFoundException;
use Exception;

class File
{
    /**
     * @throws FileNotFoundException
     */
    public function requireAsArray(string $filePath): array
    {
        try {
            return require $filePath;
        } catch (Exception) {
            throw new FileNotFoundException("File at path \"$filePath\" doesn't exist.");
        }
    }

    public function requireAsText(string $filePath): string
    {
        ob_start();
        include $filePath;

        return ob_get_clean();
    }

    public function formatPath(string $path): string
    {
        $path = str_replace('\\', '/', $path);
        while(strpos($path, '//')) {
            $path = str_replace('//', '/', $path);
        }
        return $path;
    }
}
