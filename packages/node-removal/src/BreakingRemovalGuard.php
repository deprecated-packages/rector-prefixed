<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeRemoval;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\If_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\While_;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class BreakingRemovalGuard
{
    public function ensureNodeCanBeRemove(\_PhpScopere8e811afab72\PhpParser\Node $node) : void
    {
        if ($this->isLegalNodeRemoval($node)) {
            return;
        }
        // validate the node can be removed
        $parentNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException(\sprintf('Node "%s" on line %d is child of "%s", so it cannot be removed as it would break PHP code. Change or remove the parent node instead.', \get_class($node), $node->getLine(), \get_class($parentNode)));
    }
    public function isLegalNodeRemoval(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        $parent = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_ && $parent->cond === $node) {
            return \false;
        }
        if ($parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot) {
            $parent = $parent->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        if ($parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
            return \false;
        }
        if ($this->isIfCondition($node)) {
            return \false;
        }
        return !$this->isWhileCondition($node);
    }
    private function isIfCondition(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        $parentNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_) {
            return \false;
        }
        return $parentNode->cond === $node;
    }
    private function isWhileCondition(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        $parentNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\While_) {
            return \false;
        }
        return $parentNode->cond === $node;
    }
}
