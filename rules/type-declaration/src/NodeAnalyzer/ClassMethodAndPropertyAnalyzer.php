<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\NodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
final class ClassMethodAndPropertyAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function hasClassMethodOnlyStatementReturnOfPropertyFetch(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, string $propertyName) : bool
    {
        $stmts = (array) $classMethod->stmts;
        if (\count($stmts) !== 1) {
            return \false;
        }
        $onlyClassMethodStmt = $stmts[0] ?? null;
        if (!$onlyClassMethodStmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_) {
            return \false;
        }
        /** @var Return_ $return */
        $return = $onlyClassMethodStmt;
        if (!$return->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        return $this->nodeNameResolver->isName($return->expr, $propertyName);
    }
}
