<?php

declare (strict_types=1);
namespace RectorPrefix20210423\Symplify\SimplePhpDocParser\PhpDocNodeVisitor;

use PHPStan\PhpDocParser\Ast\Node;
use RectorPrefix20210423\Symplify\SimplePhpDocParser\ValueObject\PhpDocAttributeKey;
/**
 * Mimics https://github.com/nikic/PHP-Parser/blob/master/lib/PhpParser/NodeVisitor/ParentConnectingVisitor.php
 *
 * @see \Symplify\SimplePhpDocParser\Tests\PhpDocNodeVisitor\ParentConnectingPhpDocNodeVisitorTest
 */
final class ParentConnectingPhpDocNodeVisitor extends \RectorPrefix20210423\Symplify\SimplePhpDocParser\PhpDocNodeVisitor\AbstractPhpDocNodeVisitor
{
    /**
     * @var Node[]
     */
    private $stack = [];
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     * @return void
     */
    public function beforeTraverse($node)
    {
        $this->stack = [$node];
    }
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     * @return \PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode($node)
    {
        if ($this->stack !== []) {
            $parentNode = $this->stack[\count($this->stack) - 1];
            $node->setAttribute(\RectorPrefix20210423\Symplify\SimplePhpDocParser\ValueObject\PhpDocAttributeKey::PARENT, $parentNode);
        }
        $this->stack[] = $node;
        return $node;
    }
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     * @return void
     */
    public function leaveNode($node)
    {
        \array_pop($this->stack);
    }
}
