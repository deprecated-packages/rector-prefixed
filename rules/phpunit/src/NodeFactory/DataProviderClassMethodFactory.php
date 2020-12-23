<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PHPUnit\NodeFactory;

use Iterator;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Yield_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\ValueObject\DataProviderClassMethodRecipe;
final class DataProviderClassMethodFactory
{
    public function createFromRecipe(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\ValueObject\DataProviderClassMethodRecipe $dataProviderClassMethodRecipe) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\MethodBuilder($dataProviderClassMethodRecipe->getMethodName());
        $methodBuilder->makePublic();
        $classMethod = $methodBuilder->getNode();
        foreach ($dataProviderClassMethodRecipe->getArgs() as $arg) {
            $value = $arg->value;
            if (!$value instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_) {
                continue;
            }
            foreach ($value->items as $arrayItem) {
                if (!$arrayItem instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem) {
                    continue;
                }
                $returnStatement = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Yield_(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_([new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem($arrayItem->value)]));
                $classMethod->stmts[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression($returnStatement);
            }
        }
        $this->decorateClassMethodWithReturnTypeAndTag($classMethod);
        return $classMethod;
    }
    private function decorateClassMethodWithReturnTypeAndTag(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $classMethod->returnType = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified(\Iterator::class);
    }
}
