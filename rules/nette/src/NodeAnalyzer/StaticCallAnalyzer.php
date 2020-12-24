<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Nette\NodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
final class StaticCallAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isParentCallNamed(\_PhpScopere8e811afab72\PhpParser\Node $node, string $desiredMethodName) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        if ($node->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($node->class, 'parent')) {
            return \false;
        }
        if ($node->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr) {
            return \false;
        }
        return $this->nodeNameResolver->isName($node->name, $desiredMethodName);
    }
}
