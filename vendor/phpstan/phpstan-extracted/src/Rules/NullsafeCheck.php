<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
class NullsafeCheck
{
    public function containsNullSafe(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\NullsafePropertyFetch || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\NullsafeMethodCall) {
            return \true;
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            return $this->containsNullSafe($expr->var);
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            return $this->containsNullSafe($expr->var);
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch && $expr->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr) {
            return $this->containsNullSafe($expr->class);
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return $this->containsNullSafe($expr->var);
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall && $expr->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr) {
            return $this->containsNullSafe($expr->class);
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\List_ || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_) {
            foreach ($expr->items as $item) {
                if ($item === null) {
                    continue;
                }
                if ($item->key !== null && $this->containsNullSafe($item->key)) {
                    return \true;
                }
                if ($this->containsNullSafe($item->value)) {
                    return \true;
                }
            }
        }
        return \false;
    }
}
