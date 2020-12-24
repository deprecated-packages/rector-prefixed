<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Contract\Matcher;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\Naming\ValueObject\VariableAndCallAssign;
use _PhpScopere8e811afab72\Rector\Naming\ValueObject\VariableAndCallForeach;
interface MatcherInterface
{
    public function getVariable(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
    public function getVariableName(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string;
    /**
     * @return VariableAndCallAssign|VariableAndCallForeach
     */
    public function match(\_PhpScopere8e811afab72\PhpParser\Node $node);
}
