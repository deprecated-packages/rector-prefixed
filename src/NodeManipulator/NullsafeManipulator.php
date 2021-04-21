<?php

declare (strict_types=1);
namespace Rector\Core\NodeManipulator;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\NullsafeMethodCall;
use PhpParser\Node\Expr\NullsafePropertyFetch;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Identifier;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class NullsafeManipulator
{
    /**
     * @return \PhpParser\Node\Expr|null
     */
    public function processNullSafeExpr(\PhpParser\Node\Expr $expr)
    {
        if ($expr instanceof \PhpParser\Node\Expr\MethodCall) {
            return new \PhpParser\Node\Expr\NullsafeMethodCall($expr->var, $expr->name);
        }
        if ($expr instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return new \PhpParser\Node\Expr\NullsafePropertyFetch($expr->var, $expr->name);
        }
        return null;
    }
    /**
     * @param \PhpParser\Node\Expr|null $expr
     * @return \PhpParser\Node\Expr|null
     */
    public function processNullSafeExprResult($expr, \PhpParser\Node\Identifier $nextExprIdentifier)
    {
        if ($expr === null) {
            return null;
        }
        $parentIdentifier = $nextExprIdentifier->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentIdentifier instanceof \PhpParser\Node\Expr\MethodCall || $parentIdentifier instanceof \PhpParser\Node\Expr\NullsafeMethodCall) {
            return new \PhpParser\Node\Expr\NullsafeMethodCall($expr, $nextExprIdentifier);
        }
        return new \PhpParser\Node\Expr\NullsafePropertyFetch($expr, $nextExprIdentifier);
    }
}
