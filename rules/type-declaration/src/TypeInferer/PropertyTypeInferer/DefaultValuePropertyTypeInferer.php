<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
/**
 * Special case of type inferer - it is always added in the end of the resolved types
 */
final class DefaultValuePropertyTypeInferer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function inferProperty(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $propertyProperty = $property->props[0];
        if ($propertyProperty->default === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        return $this->nodeTypeResolver->getStaticType($propertyProperty->default);
    }
    public function getPriority() : int
    {
        return 100;
    }
}
