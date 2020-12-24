<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Doctrine\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
final class RepositoryNodeFactory
{
    public function createRepositoryAssign(\_PhpScopere8e811afab72\PhpParser\Node\Expr $entityReferenceExpr) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        $propertyFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('repository'));
        $assign = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($propertyFetch, $this->createGetRepositoryMethodCall($entityReferenceExpr));
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($assign);
    }
    private function createGetRepositoryMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr $entityReferenceExpr) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall
    {
        $args = [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($entityReferenceExpr)];
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('entityManager'), 'getRepository', $args);
    }
}
