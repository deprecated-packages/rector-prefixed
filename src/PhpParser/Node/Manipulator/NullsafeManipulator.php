<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\NullsafeMethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\NullsafePropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class NullsafeManipulator
{
    public function processNullSafeExpr(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\NullsafeMethodCall($expr->var, $expr->name);
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\NullsafePropertyFetch($expr->var, $expr->name);
        }
        return null;
    }
    public function processNullSafeExprResult(?\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr, \_PhpScopere8e811afab72\PhpParser\Node\Identifier $nextExprIdentifier) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if ($expr === null) {
            return null;
        }
        $parentIdentifier = $nextExprIdentifier->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentIdentifier instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall || $parentIdentifier instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\NullsafeMethodCall) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\NullsafeMethodCall($expr, $nextExprIdentifier);
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\NullsafePropertyFetch($expr, $nextExprIdentifier);
    }
}
