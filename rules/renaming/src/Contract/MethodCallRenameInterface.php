<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Renaming\Contract;

interface MethodCallRenameInterface
{
    public function getOldClass() : string;
    public function getOldMethod() : string;
    public function getNewMethod() : string;
}
