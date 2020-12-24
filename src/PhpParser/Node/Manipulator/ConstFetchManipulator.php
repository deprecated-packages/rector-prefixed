<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch;
/**
 * Read-only utils for ClassConstAnalyzer Node:
 * "false, true..."
 */
final class ConstFetchManipulator
{
    public function isBool(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        return $this->isTrue($node) || $this->isFalse($node);
    }
    public function isFalse(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        return $this->isConstantWithLowercasedName($node, 'false');
    }
    public function isTrue(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        return $this->isConstantWithLowercasedName($node, 'true');
    }
    public function isNull(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        return $this->isConstantWithLowercasedName($node, 'null');
    }
    private function isConstantWithLowercasedName(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch) {
            return \false;
        }
        return $node->name->toLowerString() === $name;
    }
}
