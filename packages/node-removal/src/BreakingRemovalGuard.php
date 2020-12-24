<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeRemoval;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\While_;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
final class BreakingRemovalGuard
{
    public function ensureNodeCanBeRemove(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        if ($this->isLegalNodeRemoval($node)) {
            return;
        }
        // validate the node can be removed
        $parentNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException(\sprintf('Node "%s" on line %d is child of "%s", so it cannot be removed as it would break PHP code. Change or remove the parent node instead.', \get_class($node), $node->getLine(), \get_class($parentNode)));
    }
    public function isLegalNodeRemoval(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        $parent = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_ && $parent->cond === $node) {
            return \false;
        }
        if ($parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot) {
            $parent = $parent->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        if ($parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return \false;
        }
        if ($this->isIfCondition($node)) {
            return \false;
        }
        return !$this->isWhileCondition($node);
    }
    private function isIfCondition(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        $parentNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_) {
            return \false;
        }
        return $parentNode->cond === $node;
    }
    private function isWhileCondition(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        $parentNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\While_) {
            return \false;
        }
        return $parentNode->cond === $node;
    }
}
