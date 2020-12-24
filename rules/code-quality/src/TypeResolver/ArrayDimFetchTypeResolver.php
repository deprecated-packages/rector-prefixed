<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\TypeResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
final class ArrayDimFetchTypeResolver
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType
    {
        $keyStaticType = $this->resolveDimType($arrayDimFetch);
        $valueStaticType = $this->resolveValueStaticType($arrayDimFetch);
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType($keyStaticType, $valueStaticType);
    }
    private function resolveDimType(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($arrayDimFetch->dim !== null) {
            return $this->nodeTypeResolver->getStaticType($arrayDimFetch->dim);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
    private function resolveValueStaticType(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $parentParent = $arrayDimFetch->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentParent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return $this->nodeTypeResolver->getStaticType($parentParent->expr);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
}
