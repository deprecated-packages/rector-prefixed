<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\FileSystem;

use _PhpScoper0a6b37af0871\Rector\Core\Exception\FileSystem\FileNotFoundException;
final class FileGuard
{
    public function ensureFileExists(string $file, string $location) : void
    {
        if (\is_file($file) && \file_exists($file)) {
            return;
        }
        throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\FileSystem\FileNotFoundException(\sprintf('File "%s" not found in "%s".', $file, $location));
    }
}
