<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
final class ArrayDimFetchTypeResolver implements \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @required
     */
    public function autowireArrayDimFetchTypeResolver(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch::class];
    }
    /**
     * @param ArrayDimFetch $node
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $arrayDimFetchType = $this->nodeTypeResolver->resolve($node->var);
        if ($arrayDimFetchType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
            return $arrayDimFetchType->getItemType();
        }
        return $arrayDimFetchType;
    }
}
