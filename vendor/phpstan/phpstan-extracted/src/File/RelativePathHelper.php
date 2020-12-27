<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\File;

interface RelativePathHelper
{
    public function getRelativePath(string $filename) : string;
}
