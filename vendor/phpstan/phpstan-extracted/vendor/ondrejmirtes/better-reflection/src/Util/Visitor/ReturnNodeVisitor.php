<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Visitor;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\NodeTraverser;
use _PhpScoper0a2ac50786fa\PhpParser\NodeVisitorAbstract;
class ReturnNodeVisitor extends \_PhpScoper0a2ac50786fa\PhpParser\NodeVisitorAbstract
{
    /** @var Node\Stmt\Return_[] */
    private $returnNodes = [];
    public function enterNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?int
    {
        if ($this->isScopeChangingNode($node)) {
            return \_PhpScoper0a2ac50786fa\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_) {
            $this->returnNodes[] = $node;
        }
        return null;
    }
    private function isScopeChangingNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        return $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike || $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
    }
    /**
     * @return Node\Stmt\Return_[]
     */
    public function getReturnNodes() : array
    {
        return $this->returnNodes;
    }
}
