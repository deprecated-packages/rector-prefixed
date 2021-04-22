<?php

declare (strict_types=1);
namespace RectorPrefix20210422\Symplify\SmartFileSystem;

use RectorPrefix20210422\Symplify\SmartFileSystem\Exception\DirectoryNotFoundException;
use RectorPrefix20210422\Symplify\SmartFileSystem\Exception\FileNotFoundException;
final class FileSystemGuard
{
    /**
     * @return void
     */
    public function ensureFileExists(string $file, string $location)
    {
        if (\file_exists($file)) {
            return;
        }
        throw new \RectorPrefix20210422\Symplify\SmartFileSystem\Exception\FileNotFoundException(\sprintf('File "%s" not found in "%s".', $file, $location));
    }
    /**
     * @return void
     */
    public function ensureDirectoryExists(string $directory, string $extraMessage = '')
    {
        if (\is_dir($directory) && \file_exists($directory)) {
            return;
        }
        $message = \sprintf('Directory "%s" was not found.', $directory);
        if ($extraMessage !== '') {
            $message .= ' ' . $extraMessage;
        }
        throw new \RectorPrefix20210422\Symplify\SmartFileSystem\Exception\DirectoryNotFoundException($message);
    }
}
