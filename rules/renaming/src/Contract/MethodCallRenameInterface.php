<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Renaming\Contract;

interface MethodCallRenameInterface
{
    public function getOldClass() : string;
    public function getOldMethod() : string;
    public function getNewMethod() : string;
}
