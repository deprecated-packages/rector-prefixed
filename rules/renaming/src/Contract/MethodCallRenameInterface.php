<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Contract;

interface MethodCallRenameInterface
{
    public function getOldClass() : string;
    public function getOldMethod() : string;
    public function getNewMethod() : string;
}
