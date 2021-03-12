<?php

declare (strict_types=1);
namespace Rector\Doctrine\NodeFactory;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Expression;
final class RepositoryNodeFactory
{
    public function createRepositoryAssign(\PhpParser\Node\Expr $entityReferenceExpr) : \PhpParser\Node\Stmt\Expression
    {
        $propertyFetch = new \PhpParser\Node\Expr\PropertyFetch(new \PhpParser\Node\Expr\Variable('this'), new \PhpParser\Node\Identifier('repository'));
        $assign = new \PhpParser\Node\Expr\Assign($propertyFetch, $this->createGetRepositoryMethodCall($entityReferenceExpr));
        return new \PhpParser\Node\Stmt\Expression($assign);
    }
    private function createGetRepositoryMethodCall(\PhpParser\Node\Expr $entityReferenceExpr) : \PhpParser\Node\Expr\MethodCall
    {
        $args = [new \PhpParser\Node\Arg($entityReferenceExpr)];
        return new \PhpParser\Node\Expr\MethodCall(new \PhpParser\Node\Expr\Variable('entityManager'), 'getRepository', $args);
    }
}
