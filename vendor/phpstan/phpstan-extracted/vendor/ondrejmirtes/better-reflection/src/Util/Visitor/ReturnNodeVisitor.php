<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Visitor;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract;
class ReturnNodeVisitor extends \_PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract
{
    /** @var Node\Stmt\Return_[] */
    private $returnNodes = [];
    public function enterNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?int
    {
        if ($this->isScopeChangingNode($node)) {
            return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_) {
            $this->returnNodes[] = $node;
        }
        return null;
    }
    private function isScopeChangingNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
    }
    /**
     * @return Node\Stmt\Return_[]
     */
    public function getReturnNodes() : array
    {
        return $this->returnNodes;
    }
}
