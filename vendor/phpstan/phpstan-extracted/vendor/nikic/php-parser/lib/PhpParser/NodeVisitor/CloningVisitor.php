<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PhpParser\NodeVisitor;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract;
/**
 * Visitor cloning all nodes and linking to the original nodes using an attribute.
 *
 * This visitor is required to perform format-preserving pretty prints.
 */
class CloningVisitor extends \_PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract
{
    public function enterNode(\_PhpScoperb75b35f52b74\PhpParser\Node $origNode)
    {
        $node = clone $origNode;
        $node->setAttribute('origNode', $origNode);
        return $node;
    }
}
