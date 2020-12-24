<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
/** Nop/empty statement (;). */
class Nop extends \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt
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
