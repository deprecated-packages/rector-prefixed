<?php

declare (strict_types=1);
namespace PHPStan\Parser;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
class NodeChildrenVisitor extends \PhpParser\NodeVisitorAbstract
{
    /**
     * @param Node $node
     * @return null
     */
    public function enterNode(\PhpParser\Node $node)
    {
        $parentNode = $node->getAttribute('parent');
        if ($parentNode === null) {
            return null;
        }
        $parentChildren = $parentNode->getAttribute('children');
        if ($parentChildren === null) {
            $parentChildren = new \PHPStan\Parser\NodeList($node);
            $parentNode->setAttribute('children', $parentChildren);
        } else {
            $parentChildren->append($node);
        }
        return null;
    }
}
