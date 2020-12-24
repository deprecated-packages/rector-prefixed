<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\TypeResolver;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
final class ArrayDimFetchTypeResolver
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : \_PhpScopere8e811afab72\PHPStan\Type\ArrayType
    {
        $keyStaticType = $this->resolveDimType($arrayDimFetch);
        $valueStaticType = $this->resolveValueStaticType($arrayDimFetch);
        return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType($keyStaticType, $valueStaticType);
    }
    private function resolveDimType(\_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($arrayDimFetch->dim !== null) {
            return $this->nodeTypeResolver->getStaticType($arrayDimFetch->dim);
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
    private function resolveValueStaticType(\_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $parentParent = $arrayDimFetch->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentParent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
            return $this->nodeTypeResolver->getStaticType($parentParent->expr);
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
}
