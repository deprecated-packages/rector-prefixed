<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeRemoval;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\While_;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
final class BreakingRemovalGuard
{
    public function ensureNodeCanBeRemove(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : void
    {
        if ($this->isLegalNodeRemoval($node)) {
            return;
        }
        // validate the node can be removed
        $parentNode = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
        throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException(\sprintf('Node "%s" on line %d is child of "%s", so it cannot be removed as it would break PHP code. Change or remove the parent node instead.', \get_class($node), $node->getLine(), \get_class($parentNode)));
    }
    public function isLegalNodeRemoval(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        $parent = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ && $parent->cond === $node) {
            return \false;
        }
        if ($parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot) {
            $parent = $parent->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        if ($parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
            return \false;
        }
        if ($this->isIfCondition($node)) {
            return \false;
        }
        return !$this->isWhileCondition($node);
    }
    private function isIfCondition(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        $parentNode = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_) {
            return \false;
        }
        return $parentNode->cond === $node;
    }
    private function isWhileCondition(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        $parentNode = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\While_) {
            return \false;
        }
        return $parentNode->cond === $node;
    }
}
