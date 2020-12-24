<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\Contract;

interface MovedFileInterface
{
    public function getOldPathname() : string;
    public function getNewPathname() : string;
}
