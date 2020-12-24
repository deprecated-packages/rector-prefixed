<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;

use _PhpScoperb75b35f52b74\PhpParser\Node;
/** Nop/empty statement (;). */
class Nop extends \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt
{
    public function getSubNodeNames() : array
    {
        return [];
    }
    public function getType() : string
    {
        return 'Stmt_Nop';
    }
}
