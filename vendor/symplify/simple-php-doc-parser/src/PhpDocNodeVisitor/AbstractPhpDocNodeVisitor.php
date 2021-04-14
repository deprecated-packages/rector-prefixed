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
    public function beforeTraverse(Node $node): void
    {
    }

    public function enterNode(Node $node): ?Node
    {
        return null;
    }

    public function leaveNode(Node $node): void
    {
    }

    public function afterTraverse(Node $node): void
    {
    }
}
