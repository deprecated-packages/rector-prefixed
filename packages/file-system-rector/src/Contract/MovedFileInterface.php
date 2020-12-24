<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\FileSystemRector\Contract;

interface MovedFileInterface
{
    public function getOldPathname() : string;
    public function getNewPathname() : string;
}
