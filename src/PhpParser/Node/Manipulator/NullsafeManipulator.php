<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\NullsafeMethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\NullsafePropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
final class NullsafeManipulator
{
    public function processNullSafeExpr(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\NullsafeMethodCall($expr->var, $expr->name);
        }
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\NullsafePropertyFetch($expr->var, $expr->name);
        }
        return null;
    }
    public function processNullSafeExprResult(?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr, \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier $nextExprIdentifier) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if ($expr === null) {
            return null;
        }
        $parentIdentifier = $nextExprIdentifier->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentIdentifier instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall || $parentIdentifier instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\NullsafeMethodCall) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\NullsafeMethodCall($expr, $nextExprIdentifier);
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\NullsafePropertyFetch($expr, $nextExprIdentifier);
    }
}
