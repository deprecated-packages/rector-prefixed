<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Visitor;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\NodeTraverser;
use _PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract;
class ReturnNodeVisitor extends \_PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract
{
    /** @var Node\Stmt\Return_[] */
    private $returnNodes = [];
    public function enterNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?int
    {
        if ($this->isScopeChangingNode($node)) {
            return \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_) {
            $this->returnNodes[] = $node;
        }
        return null;
    }
    private function isScopeChangingNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        return $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike || $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
    }
    /**
     * @return Node\Stmt\Return_[]
     */
    public function getReturnNodes() : array
    {
        return $this->returnNodes;
    }
}
