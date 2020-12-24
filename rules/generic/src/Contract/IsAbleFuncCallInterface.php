<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Contract;

interface IsAbleFuncCallInterface
{
    public function getFuncName() : string;
    public function getPhpVersion() : int;
    public function getType() : string;
}
