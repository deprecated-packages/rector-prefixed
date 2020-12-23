<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver;
/**
 * Special case of type inferer - it is always added in the end of the resolved types
 */
final class DefaultValuePropertyTypeInferer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function inferProperty(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $property) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $propertyProperty = $property->props[0];
        if ($propertyProperty->default === null) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
        }
        return $this->nodeTypeResolver->getStaticType($propertyProperty->default);
    }
    public function getPriority() : int
    {
        return 100;
    }
}
