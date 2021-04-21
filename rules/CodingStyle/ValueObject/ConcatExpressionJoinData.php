<?php

declare(strict_types=1);

namespace Rector\CodingStyle\ValueObject;

use PhpParser\Node;
use PhpParser\Node\Expr;

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

    /**
     * @return void
     */
    public function addString(string $value)
    {
        $this->values[] = $value;
    }

    /**
     * @return void
     */
    public function addNodeToRemove(Node $node)
    {
        $this->nodesToRemove[] = $node;
    }

    public function getString(): string
    {
        return implode('', $this->values);
    }

    /**
     * @return Node[]
     */
    public function getNodesToRemove(): array
    {
        return $this->nodesToRemove;
    }

    /**
     * @return void
     */
    public function addPlaceholderToNode(string $objectHash, Expr $expr)
    {
        $this->placeholdersToNodes[$objectHash] = $expr;
    }

    /**
     * @return Expr[]
     */
    public function getPlaceholdersToNodes(): array
    {
        return $this->placeholdersToNodes;
    }
}
