<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\NodeFactory;

use Iterator;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Yield_;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScopere8e811afab72\Rector\PHPUnit\ValueObject\DataProviderClassMethodRecipe;
final class DataProviderClassMethodFactory
{
    public function createFromRecipe(\_PhpScopere8e811afab72\Rector\PHPUnit\ValueObject\DataProviderClassMethodRecipe $dataProviderClassMethodRecipe) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\MethodBuilder($dataProviderClassMethodRecipe->getMethodName());
        $methodBuilder->makePublic();
        $classMethod = $methodBuilder->getNode();
        foreach ($dataProviderClassMethodRecipe->getArgs() as $arg) {
            $value = $arg->value;
            if (!$value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_) {
                continue;
            }
            foreach ($value->items as $arrayItem) {
                if (!$arrayItem instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem) {
                    continue;
                }
                $returnStatement = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Yield_(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_([new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem($arrayItem->value)]));
                $classMethod->stmts[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($returnStatement);
            }
        }
        $this->decorateClassMethodWithReturnTypeAndTag($classMethod);
        return $classMethod;
    }
    private function decorateClassMethodWithReturnTypeAndTag(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $classMethod->returnType = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified(\Iterator::class);
    }
}
