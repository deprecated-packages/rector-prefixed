<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch;
/**
 * Read-only utils for ClassConstAnalyzer Node:
 * "false, true..."
 */
final class ConstFetchManipulator
{
    public function isBool(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool
    {
        return $this->isTrue($node) || $this->isFalse($node);
    }
    public function isFalse(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool
    {
        return $this->isConstantWithLowercasedName($node, 'false');
    }
    public function isTrue(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool
    {
        return $this->isConstantWithLowercasedName($node, 'true');
    }
    public function isNull(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool
    {
        return $this->isConstantWithLowercasedName($node, 'null');
    }
    private function isConstantWithLowercasedName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch) {
            return \false;
        }
        return $node->name->toLowerString() === $name;
    }
}
