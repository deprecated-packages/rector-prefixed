<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\Array_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp71\Tests\Rector\Array_\SymmetricArrayDestructuringToListRector\SymmetricArrayDestructuringToListRectorTest
 */
final class SymmetricArrayDestructuringToListRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Downgrade Symmetric array destructuring to list() function', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('[$id1, $name1] = $data;', 'list($id1, $name1) = $data;')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_::class];
    }
    /**
     * @param Array_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $parentNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign && $this->areNodesEqual($node, $parentNode->var)) {
            return $this->processToList($node);
        }
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_ && $this->areNodesEqual($node, $parentNode->valueVar)) {
            return $this->processToList($node);
        }
        return null;
    }
    private function processToList(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_ $array) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall
    {
        $args = [];
        foreach ($array->items as $arrayItem) {
            if (!$arrayItem instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem) {
                continue;
            }
            $args[] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg($arrayItem->value);
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall(new \_PhpScopere8e811afab72\PhpParser\Node\Name('list'), $args);
    }
}
