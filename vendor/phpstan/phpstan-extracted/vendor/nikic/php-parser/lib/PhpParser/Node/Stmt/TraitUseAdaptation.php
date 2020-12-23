<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
abstract class TraitUseAdaptation extends \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt
{
    /** @var Node\Name|null Trait name */
    public $trait;
    /** @var Node\Identifier Method name */
    public $method;
}
