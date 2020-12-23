<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodeQuality\TypeResolver;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver;
final class ArrayDimFetchTypeResolver
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function resolve(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType
    {
        $keyStaticType = $this->resolveDimType($arrayDimFetch);
        $valueStaticType = $this->resolveValueStaticType($arrayDimFetch);
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType($keyStaticType, $valueStaticType);
    }
    private function resolveDimType(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($arrayDimFetch->dim !== null) {
            return $this->nodeTypeResolver->getStaticType($arrayDimFetch->dim);
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
    }
    private function resolveValueStaticType(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $parentParent = $arrayDimFetch->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentParent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
            return $this->nodeTypeResolver->getStaticType($parentParent->expr);
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
    }
}
