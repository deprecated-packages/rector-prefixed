<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Visitor;

use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
class ReturnNodeVisitor extends \PhpParser\NodeVisitorAbstract
{
    /** @var Node\Stmt\Return_[] */
    private $returnNodes = [];
    public function enterNode(\PhpParser\Node $node) : ?int
    {
        if ($this->isScopeChangingNode($node)) {
            return \PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
        if ($node instanceof \PhpParser\Node\Stmt\Return_) {
            $this->returnNodes[] = $node;
        }
        return null;
    }
    private function isScopeChangingNode(\PhpParser\Node $node) : bool
    {
        return $node instanceof \PhpParser\Node\FunctionLike || $node instanceof \PhpParser\Node\Stmt\Class_;
    }
    /**
     * @return Node\Stmt\Return_[]
     */
    public function getReturnNodes() : array
    {
        return $this->returnNodes;
    }
}
