<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\NodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
final class ClassMethodAndPropertyAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function hasClassMethodOnlyStatementReturnOfPropertyFetch(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, string $propertyName) : bool
    {
        $stmts = (array) $classMethod->stmts;
        if (\count($stmts) !== 1) {
            return \false;
        }
        $onlyClassMethodStmt = $stmts[0] ?? null;
        if (!$onlyClassMethodStmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
            return \false;
        }
        /** @var Return_ $return */
        $return = $onlyClassMethodStmt;
        if (!$return->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        return $this->nodeNameResolver->isName($return->expr, $propertyName);
    }
}
