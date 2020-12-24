<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\Contract\Matcher;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\Rector\Naming\ValueObject\VariableAndCallAssign;
use _PhpScoper0a6b37af0871\Rector\Naming\ValueObject\VariableAndCallForeach;
interface MatcherInterface
{
    public function getVariable(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
    public function getVariableName(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?string;
    /**
     * @return VariableAndCallAssign|VariableAndCallForeach
     */
    public function match(\_PhpScoper0a6b37af0871\PhpParser\Node $node);
}
