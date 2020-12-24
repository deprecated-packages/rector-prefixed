<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\File;

class NullRelativePathHelper implements \_PhpScoper0a6b37af0871\PHPStan\File\RelativePathHelper
{
    public function getRelativePath(string $filename) : string
    {
        return $filename;
    }
}
