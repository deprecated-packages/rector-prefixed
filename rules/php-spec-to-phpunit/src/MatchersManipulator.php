<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
final class MatchersManipulator
{
    /**
     * @return string[]
     */
    public function resolveMatcherNamesFromClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $classMethod = $class->getMethod('getMatchers');
        if ($classMethod === null) {
            return [];
        }
        if (!isset($classMethod->stmts[0])) {
            return [];
        }
        if (!$classMethod->stmts[0] instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_) {
            return [];
        }
        /** @var Return_ $return */
        $return = $classMethod->stmts[0];
        if (!$return->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_) {
            return [];
        }
        $keys = [];
        foreach ($return->expr->items as $arrayItem) {
            if ($arrayItem === null) {
                continue;
            }
            if ($arrayItem->key instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
                $keys[] = $arrayItem->key->value;
            }
        }
        return $keys;
    }
}
