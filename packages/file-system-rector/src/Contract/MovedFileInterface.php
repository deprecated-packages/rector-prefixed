<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\FileSystemRector\Contract;

interface MovedFileInterface
{
    public function getOldPathname() : string;
    public function getNewPathname() : string;
}
