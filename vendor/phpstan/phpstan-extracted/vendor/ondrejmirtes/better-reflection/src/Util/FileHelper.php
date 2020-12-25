<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util;

use function preg_match;
use function str_replace;
use const DIRECTORY_SEPARATOR;
class FileHelper
{
    public static function normalizeWindowsPath(string $path) : string
    {
        return \str_replace('\\', '/', $path);
    }
    public static function normalizeSystemPath(string $originalPath, string $directorySeparator = \DIRECTORY_SEPARATOR) : string
    {
        $originalPath = self::normalizeWindowsPath($originalPath);
        \preg_match('~^([a-z]+)\\:\\/\\/(.+)~', $originalPath, $matches);
        if ($matches !== []) {
            [, $scheme, $path] = $matches;
        } else {
            $scheme = null;
            $path = $originalPath;
        }
        return ($scheme !== null ? $scheme . '://' : '') . ($directorySeparator === '\\' ? \str_replace('/', '\\', $path) : $path);
    }
}
