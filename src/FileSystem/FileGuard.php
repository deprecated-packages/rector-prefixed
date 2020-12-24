<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\FileSystem;

use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\FileSystem\FileNotFoundException;
final class FileGuard
{
    public function ensureFileExists(string $file, string $location) : void
    {
        if (\is_file($file) && \file_exists($file)) {
            return;
        }
        throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\FileSystem\FileNotFoundException(\sprintf('File "%s" not found in "%s".', $file, $location));
    }
}
