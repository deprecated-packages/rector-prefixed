<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
/** Nop/empty statement (;). */
class Nop extends \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt
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
