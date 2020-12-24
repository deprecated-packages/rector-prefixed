<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Configuration;

use _PhpScoperb75b35f52b74\PhpParser\Node;
final class CurrentNodeProvider
{
    /**
     * @var Node|null
     */
    private $node;
    public function setNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        $this->node = $node;
    }
    public function getNode() : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return $this->node;
    }
}
