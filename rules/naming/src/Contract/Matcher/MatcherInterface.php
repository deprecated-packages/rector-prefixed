<?php

declare (strict_types=1);
namespace Rector\Naming\Contract\Matcher;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use Rector\Naming\ValueObject\VariableAndCallAssign;
use Rector\Naming\ValueObject\VariableAndCallForeach;
interface MatcherInterface
{
    public function getVariable(\PhpParser\Node $node) : \PhpParser\Node\Expr\Variable;
    public function getVariableName(\PhpParser\Node $node) : ?string;
    /**
     * @return VariableAndCallAssign|VariableAndCallForeach
     */
    public function match(\PhpParser\Node $node);
}
