<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Visitor;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeTraverser;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeVisitorAbstract;
class ReturnNodeVisitor extends \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeVisitorAbstract
{
    /** @var Node\Stmt\Return_[] */
    private $returnNodes = [];
    public function enterNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?int
    {
        if ($this->isScopeChangingNode($node)) {
            return \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_) {
            $this->returnNodes[] = $node;
        }
        return null;
    }
    private function isScopeChangingNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool
    {
        return $node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike || $node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
    }
    /**
     * @return Node\Stmt\Return_[]
     */
    public function getReturnNodes() : array
    {
        return $this->returnNodes;
    }
}
