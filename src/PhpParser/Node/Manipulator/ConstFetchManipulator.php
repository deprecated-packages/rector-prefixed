<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch;
/**
 * Read-only utils for ClassConstAnalyzer Node:
 * "false, true..."
 */
final class ConstFetchManipulator
{
    public function isBool(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->isTrue($node) || $this->isFalse($node);
    }
    public function isFalse(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->isConstantWithLowercasedName($node, 'false');
    }
    public function isTrue(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->isConstantWithLowercasedName($node, 'true');
    }
    public function isNull(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->isConstantWithLowercasedName($node, 'null');
    }
    private function isConstantWithLowercasedName(\_PhpScopere8e811afab72\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch) {
            return \false;
        }
        return $node->name->toLowerString() === $name;
    }
}
