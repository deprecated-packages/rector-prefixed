<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\File;

class NullRelativePathHelper implements \RectorPrefix20201227\PHPStan\File\RelativePathHelper
{
    public function getRelativePath(string $filename) : string
    {
        return $filename;
    }
}
