<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\ValueObject;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
final class ConcatExpressionJoinData
{
    /**
     * @var string[]
     */
    private $values = [];
    /**
     * @var Node[]
     */
    private $nodesToRemove = [];
    /**
     * @var Expr[]
     */
    private $placeholdersToNodes = [];
    public function addString(string $value) : void
    {
        $this->values[] = $value;
    }
    public function addNodeToRemove(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : void
    {
        $this->nodesToRemove[] = $node;
    }
    public function getString() : string
    {
        return \implode('', $this->values);
    }
    /**
     * @return Node[]
     */
    public function getNodesToRemove() : array
    {
        return $this->nodesToRemove;
    }
    public function addPlaceholderToNode(string $objectHash, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : void
    {
        $this->placeholdersToNodes[$objectHash] = $expr;
    }
    /**
     * @return Expr[]
     */
    public function getPlaceholdersToNodes() : array
    {
        return $this->placeholdersToNodes;
    }
}
