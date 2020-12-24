<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Doctrine\NodeFactory;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression;
final class RepositoryNodeFactory
{
    public function createRepositoryAssign(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $entityReferenceExpr) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression
    {
        $propertyFetch = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable('this'), new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier('repository'));
        $assign = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign($propertyFetch, $this->createGetRepositoryMethodCall($entityReferenceExpr));
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression($assign);
    }
    private function createGetRepositoryMethodCall(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $entityReferenceExpr) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall
    {
        $args = [new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($entityReferenceExpr)];
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable('entityManager'), 'getRepository', $args);
    }
}
