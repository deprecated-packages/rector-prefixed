<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Visitor;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract;
class ReturnNodeVisitor extends \_PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract
{
    /** @var Node\Stmt\Return_[] */
    private $returnNodes = [];
    public function enterNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?int
    {
        if ($this->isScopeChangingNode($node)) {
            return \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
            $this->returnNodes[] = $node;
        }
        return null;
    }
    private function isScopeChangingNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        return $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
    }
    /**
     * @return Node\Stmt\Return_[]
     */
    public function getReturnNodes() : array
    {
        return $this->returnNodes;
    }
}
