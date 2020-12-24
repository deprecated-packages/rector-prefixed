<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
abstract class TraitUseAdaptation extends \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt
{
    /** @var Node\Name|null Trait name */
    public $trait;
    /** @var Node\Identifier Method name */
    public $method;
}
