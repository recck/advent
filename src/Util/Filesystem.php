<?php

namespace Advent\Util;

class Filesystem
{
    /**
     * @param string $path
     * @return string
     */
    public function contents(string $path): string
    {
        return file_get_contents($path);
    }

    /**
     * @param string $path
     * @return array
     */
    public function contentsAsArray(string $path): array
    {
        return file($path);
    }
}
