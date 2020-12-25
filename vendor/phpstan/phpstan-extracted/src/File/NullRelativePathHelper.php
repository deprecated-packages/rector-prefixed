<?php

declare (strict_types=1);
namespace PHPStan\File;

class NullRelativePathHelper implements \PHPStan\File\RelativePathHelper
{
    public function getRelativePath(string $filename) : string
    {
        return $filename;
    }
}
