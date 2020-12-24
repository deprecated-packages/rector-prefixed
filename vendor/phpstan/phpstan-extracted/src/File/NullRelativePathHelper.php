<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\File;

class NullRelativePathHelper implements \_PhpScoperb75b35f52b74\PHPStan\File\RelativePathHelper
{
    public function getRelativePath(string $filename) : string
    {
        return $filename;
    }
}
