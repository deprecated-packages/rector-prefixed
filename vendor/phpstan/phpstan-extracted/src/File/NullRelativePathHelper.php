<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\File;

class NullRelativePathHelper implements \_PhpScopere8e811afab72\PHPStan\File\RelativePathHelper
{
    public function getRelativePath(string $filename) : string
    {
        return $filename;
    }
}
