<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\Configuration;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
final class CurrentNodeProvider
{
    /**
     * @var Node|null
     */
    private $node;
    public function setNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void
    {
        $this->node = $node;
    }
    public function getNode() : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        return $this->node;
    }
}
