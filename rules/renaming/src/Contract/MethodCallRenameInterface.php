<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Renaming\Contract;

interface MethodCallRenameInterface
{
    public function getOldClass() : string;
    public function getOldMethod() : string;
    public function getNewMethod() : string;
}
