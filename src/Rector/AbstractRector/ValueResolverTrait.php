<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Value\ValueResolver;
/**
 * This could be part of @see AbstractRector, but decopuling to trait
 * makes clear what code has 1 purpose.
 */
trait ValueResolverTrait
{
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    /**
     * @required
     */
    public function autowireValueResolverTrait(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver) : void
    {
        $this->valueResolver = $valueResolver;
    }
    /**
     * @return mixed|mixed[]
     */
    protected function getValue(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr, bool $resolvedClassReference = \false)
    {
        return $this->valueResolver->getValue($expr, $resolvedClassReference);
    }
    /**
     * @param mixed $expectedValue
     */
    protected function isValue(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr, $expectedValue) : bool
    {
        return $this->getValue($expr) === $expectedValue;
    }
    /**
     * @param mixed[] $expectedValues
     */
    protected function isValues(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr, array $expectedValues) : bool
    {
        foreach ($expectedValues as $expectedValue) {
            if ($this->isValue($expr, $expectedValue)) {
                return \true;
            }
        }
        return \false;
    }
}
