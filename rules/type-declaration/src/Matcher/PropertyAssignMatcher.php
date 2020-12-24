<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\Matcher;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
final class PropertyAssignMatcher
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * Covers:
     * - $this->propertyName = $expr;
     * - $this->propertyName[] = $expr;
     */
    public function matchPropertyAssignExpr(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign, string $propertyName) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if ($this->isPropertyFetch($assign->var)) {
            if (!$this->nodeNameResolver->isName($assign->var, $propertyName)) {
                return null;
            }
            return $assign->expr;
        }
        if ($assign->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch && $this->isPropertyFetch($assign->var->var)) {
            if (!$this->nodeNameResolver->isName($assign->var->var, $propertyName)) {
                return null;
            }
            return $assign->expr;
        }
        return null;
    }
    private function isPropertyFetch(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            return \true;
        }
        return $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch;
    }
}
