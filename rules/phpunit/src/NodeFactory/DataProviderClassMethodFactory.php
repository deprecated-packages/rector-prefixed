<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\NodeFactory;

use Iterator;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Yield_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\ValueObject\DataProviderClassMethodRecipe;
final class DataProviderClassMethodFactory
{
    public function createFromRecipe(\_PhpScoperb75b35f52b74\Rector\PHPUnit\ValueObject\DataProviderClassMethodRecipe $dataProviderClassMethodRecipe) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder($dataProviderClassMethodRecipe->getMethodName());
        $methodBuilder->makePublic();
        $classMethod = $methodBuilder->getNode();
        foreach ($dataProviderClassMethodRecipe->getArgs() as $arg) {
            $value = $arg->value;
            if (!$value instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_) {
                continue;
            }
            foreach ($value->items as $arrayItem) {
                if (!$arrayItem instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem) {
                    continue;
                }
                $returnStatement = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Yield_(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_([new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem($arrayItem->value)]));
                $classMethod->stmts[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($returnStatement);
            }
        }
        $this->decorateClassMethodWithReturnTypeAndTag($classMethod);
        return $classMethod;
    }
    private function decorateClassMethodWithReturnTypeAndTag(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $classMethod->returnType = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified(\Iterator::class);
    }
}
