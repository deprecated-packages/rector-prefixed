<?php

declare (strict_types=1);
namespace Rector\Core\Contract\Rector;

use PhpParser\Node;
use PhpParser\NodeVisitor;
interface PhpRectorInterface extends \PhpParser\NodeVisitor, \Rector\Core\Contract\Rector\RectorInterface
{
    /**
     * List of nodes this class checks, classes that implements \PhpParser\Node
     * See beautiful map of all nodes https://github.com/rectorphp/rector/blob/master/docs/nodes_overview.md
     *
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array;
    /**
     * Process Node of matched type
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node;
}
