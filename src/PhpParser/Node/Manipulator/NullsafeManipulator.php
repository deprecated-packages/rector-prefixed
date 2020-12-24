<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\NullsafeMethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\NullsafePropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class NullsafeManipulator
{
    public function processNullSafeExpr(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\NullsafeMethodCall($expr->var, $expr->name);
        }
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\NullsafePropertyFetch($expr->var, $expr->name);
        }
        return null;
    }
    public function processNullSafeExprResult(?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr, \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier $nextExprIdentifier) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        if ($expr === null) {
            return null;
        }
        $parentIdentifier = $nextExprIdentifier->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentIdentifier instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall || $parentIdentifier instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\NullsafeMethodCall) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\NullsafeMethodCall($expr, $nextExprIdentifier);
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\NullsafePropertyFetch($expr, $nextExprIdentifier);
    }
}
