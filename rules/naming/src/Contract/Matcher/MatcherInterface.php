<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\Contract\Matcher;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\Rector\Naming\ValueObject\VariableAndCallAssign;
use _PhpScoper0a2ac50786fa\Rector\Naming\ValueObject\VariableAndCallForeach;
interface MatcherInterface
{
    public function getVariable(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
    public function getVariableName(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?string;
    /**
     * @return VariableAndCallAssign|VariableAndCallForeach
     */
    public function match(\_PhpScoper0a2ac50786fa\PhpParser\Node $node);
}
