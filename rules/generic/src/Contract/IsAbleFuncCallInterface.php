<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Generic\Contract;

interface IsAbleFuncCallInterface
{
    public function getFuncName() : string;
    public function getPhpVersion() : int;
    public function getType() : string;
}
