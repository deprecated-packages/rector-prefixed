<?php

declare (strict_types=1);
namespace Rector\Core\Configuration;

use PhpParser\Node;
final class CurrentNodeProvider
{
    /**
     * @var Node|null
     */
    private $node;
    /**
     * @return void
     */
    public function setNode(\PhpParser\Node $node)
    {
        $this->node = $node;
    }
    public function getNode() : ?\PhpParser\Node
    {
        return $this->node;
    }
}
