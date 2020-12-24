<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\File;

class FileWriter
{
    public static function write(string $fileName, string $contents) : void
    {
        $success = @\file_put_contents($fileName, $contents);
        if ($success === \false) {
            $error = \error_get_last();
            throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\File\CouldNotWriteFileException($fileName, $error !== null ? $error['message'] : 'unknown cause');
        }
    }
}
