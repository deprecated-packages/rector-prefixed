<?php

declare (strict_types=1);
namespace PHPStan\Rules;

use PhpParser\Node\Expr;
class NullsafeCheck
{
    public function containsNullSafe(\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \PhpParser\Node\Expr\NullsafePropertyFetch || $expr instanceof \PhpParser\Node\Expr\NullsafeMethodCall) {
            return \true;
        }
        if ($expr instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
            return $this->containsNullSafe($expr->var);
        }
        if ($expr instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return $this->containsNullSafe($expr->var);
        }
        if ($expr instanceof \PhpParser\Node\Expr\StaticPropertyFetch && $expr->class instanceof \PhpParser\Node\Expr) {
            return $this->containsNullSafe($expr->class);
        }
        if ($expr instanceof \PhpParser\Node\Expr\MethodCall) {
            return $this->containsNullSafe($expr->var);
        }
        if ($expr instanceof \PhpParser\Node\Expr\StaticCall && $expr->class instanceof \PhpParser\Node\Expr) {
            return $this->containsNullSafe($expr->class);
        }
        if ($expr instanceof \PhpParser\Node\Expr\List_ || $expr instanceof \PhpParser\Node\Expr\Array_) {
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
