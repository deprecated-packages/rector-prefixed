<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Configuration;

use _PhpScopere8e811afab72\PhpParser\Node;
final class CurrentNodeProvider
{
    /**
     * @var Node|null
     */
    private $node;
    public function setNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : void
    {
        $this->node = $node;
    }
    public function getNode() : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->node;
    }
}
