<?php

declare(strict_types=1);

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
    public function setNode(Node $node)
    {
        $this->node = $node;
    }

    /**
     * @return \PhpParser\Node|null
     */
    public function getNode()
    {
        return $this->node;
    }
}
