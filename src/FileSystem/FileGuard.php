<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\FileSystem;

use _PhpScoperb75b35f52b74\Rector\Core\Exception\FileSystem\FileNotFoundException;
final class FileGuard
{
    public function ensureFileExists(string $file, string $location) : void
    {
        if (\is_file($file) && \file_exists($file)) {
            return;
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\FileSystem\FileNotFoundException(\sprintf('File "%s" not found in "%s".', $file, $location));
    }
}
