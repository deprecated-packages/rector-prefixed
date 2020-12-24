<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Contract;

interface IsAbleFuncCallInterface
{
    public function getFuncName() : string;
    public function getPhpVersion() : int;
    public function getType() : string;
}
