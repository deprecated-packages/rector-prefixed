<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Doctrine\NodeFactory;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
final class RepositoryNodeFactory
{
    public function createRepositoryAssign(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $entityReferenceExpr) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression
    {
        $propertyFetch = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable('this'), new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier('repository'));
        $assign = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign($propertyFetch, $this->createGetRepositoryMethodCall($entityReferenceExpr));
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression($assign);
    }
    private function createGetRepositoryMethodCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $entityReferenceExpr) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall
    {
        $args = [new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($entityReferenceExpr)];
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable('entityManager'), 'getRepository', $args);
    }
}
