<?php

declare(strict_types=1);

namespace Symplify\SimplePhpDocParser\PhpDocNodeVisitor;

use PHPStan\PhpDocParser\Ast\Node;
use Symplify\SimplePhpDocParser\Contract\PhpDocNodeVisitorInterface;

/**
 * Inspired by https://github.com/nikic/PHP-Parser/blob/master/lib/PhpParser/NodeVisitorAbstract.php
 */
abstract class AbstractPhpDocNodeVisitor implements PhpDocNodeVisitorInterface
{
    /**
     * @return void
     */
    public function beforeTraverse(Node $node)
    {
    }

    /**
     * @return \PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode(Node $node)
    {
        return null;
    }

    /**
     * @return void
     */
    public function leaveNode(Node $node)
    {
    }

    /**
     * @return void
     */
    public function afterTraverse(Node $node)
    {
    }
}
