<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
class NullsafeCheck
{
    public function containsNullSafe(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\NullsafePropertyFetch || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\NullsafeMethodCall) {
            return \true;
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch) {
            return $this->containsNullSafe($expr->var);
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch) {
            return $this->containsNullSafe($expr->var);
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch && $expr->class instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr) {
            return $this->containsNullSafe($expr->class);
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            return $this->containsNullSafe($expr->var);
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall && $expr->class instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr) {
            return $this->containsNullSafe($expr->class);
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\List_ || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_) {
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
