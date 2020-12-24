<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Configuration;

use _PhpScoper0a6b37af0871\PhpParser\Node;
final class CurrentNodeProvider
{
    /**
     * @var Node|null
     */
    private $node;
    public function setNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : void
    {
        $this->node = $node;
    }
    public function getNode() : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        return $this->node;
    }
}
