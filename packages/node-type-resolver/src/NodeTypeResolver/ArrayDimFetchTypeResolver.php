<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\NodeTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrayDimFetch;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Type;
use Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class ArrayDimFetchTypeResolver implements \Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @required
     */
    public function autowireArrayDimFetchTypeResolver(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\PhpParser\Node\Expr\ArrayDimFetch::class];
    }
    /**
     * @param ArrayDimFetch $node
     */
    public function resolve(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        $arrayDimFetchType = $this->nodeTypeResolver->resolve($node->var);
        if ($arrayDimFetchType instanceof \PHPStan\Type\ArrayType) {
            return $arrayDimFetchType->getItemType();
        }
        return $arrayDimFetchType;
    }
}
