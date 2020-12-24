<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Generic\Contract;

interface IsAbleFuncCallInterface
{
    public function getFuncName() : string;
    public function getPhpVersion() : int;
    public function getType() : string;
}
