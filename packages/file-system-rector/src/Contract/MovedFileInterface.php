<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\FileSystemRector\Contract;

interface MovedFileInterface
{
    public function getOldPathname() : string;
    public function getNewPathname() : string;
}
