<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\File;

class NullRelativePathHelper implements \_PhpScoper0a2ac50786fa\PHPStan\File\RelativePathHelper
{
    public function getRelativePath(string $filename) : string
    {
        return $filename;
    }
}
