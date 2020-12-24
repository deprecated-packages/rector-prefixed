<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Doctrine\NodeFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
final class RepositoryNodeFactory
{
    public function createRepositoryAssign(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $entityReferenceExpr) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression
    {
        $propertyFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this'), new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier('repository'));
        $assign = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($propertyFetch, $this->createGetRepositoryMethodCall($entityReferenceExpr));
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($assign);
    }
    private function createGetRepositoryMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $entityReferenceExpr) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        $args = [new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($entityReferenceExpr)];
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('entityManager'), 'getRepository', $args);
    }
}
