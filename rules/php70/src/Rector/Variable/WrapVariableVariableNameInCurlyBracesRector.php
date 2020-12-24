<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php70\Rector\Variable;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Php70\Tests\Rector\Variable\WrapVariableVariableNameInCurlyBracesRector\WrapVariableVariableNameInCurlyBracesRectorTest
 * @see https://www.php.net/manual/en/language.variables.variable.php
 */
final class WrapVariableVariableNameInCurlyBracesRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Ensure variable variables are wrapped in curly braces', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
function run($foo)
{
    global $$foo->bar;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
function run($foo)
{
    global ${$foo->bar};
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable::class];
    }
    /**
     * @param Variable $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $nodeName = $node->name;
        if (!$nodeName instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch && !$nodeName instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return null;
        }
        if ($node->getEndTokenPos() !== $nodeName->getEndTokenPos()) {
            return null;
        }
        if ($nodeName instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch($nodeName->var, $nodeName->name));
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($nodeName->name));
    }
}
