<?php

declare(strict_types=1);

namespace Symplify\SimplePhpDocParser\PhpDocNodeVisitor;

use PHPStan\PhpDocParser\Ast\Node;
use Symplify\SimplePhpDocParser\ValueObject\PhpDocAttributeKey;

/**
 * Mimics https://github.com/nikic/PHP-Parser/blob/master/lib/PhpParser/NodeVisitor/ParentConnectingVisitor.php
 *
 * @see \Symplify\SimplePhpDocParser\Tests\PhpDocNodeVisitor\ParentConnectingPhpDocNodeVisitorTest
 */
final class ParentConnectingPhpDocNodeVisitor extends AbstractPhpDocNodeVisitor
{
    /**
     * @var Node[]
     */
    private $stack = [];

    /**
     * @return void
     */
    public function beforeTraverse(Node $node)
    {
        $this->stack = [$node];
    }

    /**
     * @return \PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode(Node $node)
    {
        if ($this->stack !== []) {
            $parentNode = $this->stack[count($this->stack) - 1];
            $node->setAttribute(PhpDocAttributeKey::PARENT, $parentNode);
        }

        $this->stack[] = $node;

        return $node;
    }

    /**
     * @return void
     */
    public function leaveNode(Node $node)
    {
        array_pop($this->stack);
    }
}
