<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\Configuration;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
final class CurrentNodeProvider
{
    /**
     * @var Node|null
     */
    private $node;
    public function setNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : void
    {
        $this->node = $node;
    }
    public function getNode() : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        return $this->node;
    }
}
