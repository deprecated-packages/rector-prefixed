<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch;
/**
 * Read-only utils for ClassConstAnalyzer Node:
 * "false, true..."
 */
final class ConstFetchManipulator
{
    public function isBool(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        return $this->isTrue($node) || $this->isFalse($node);
    }
    public function isFalse(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        return $this->isConstantWithLowercasedName($node, 'false');
    }
    public function isTrue(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        return $this->isConstantWithLowercasedName($node, 'true');
    }
    public function isNull(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        return $this->isConstantWithLowercasedName($node, 'null');
    }
    private function isConstantWithLowercasedName(\_PhpScoperb75b35f52b74\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch) {
            return \false;
        }
        return $node->name->toLowerString() === $name;
    }
}
