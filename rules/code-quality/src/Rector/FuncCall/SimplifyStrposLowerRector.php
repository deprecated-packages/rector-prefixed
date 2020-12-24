<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\Rector\FuncCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\FuncCall\SimplifyStrposLowerRector\SimplifyStrposLowerRectorTest
 */
final class SimplifyStrposLowerRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify strpos(strtolower(), "...") calls', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('strpos(strtolower($var), "...")"', 'stripos($var, "...")"')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isName($node, 'strpos')) {
            return null;
        }
        if (!isset($node->args[0])) {
            return null;
        }
        if (!$node->args[0]->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
            return null;
        }
        /** @var FuncCall $innerFuncCall */
        $innerFuncCall = $node->args[0]->value;
        if (!$this->isName($innerFuncCall, 'strtolower')) {
            return null;
        }
        // pop 1 level up
        $node->args[0] = $innerFuncCall->args[0];
        $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Name('stripos');
        return $node;
    }
}
