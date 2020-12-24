<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NeverType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\VoidType;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\DoctrineTypeAnalyzer;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer\DefaultValuePropertyTypeInferer;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer\VarDocPropertyTypeInferer;
final class PropertyTypeInferer extends \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\AbstractPriorityAwareTypeInferer
{
    /**
     * @var PropertyTypeInfererInterface[]
     */
    private $propertyTypeInferers = [];
    /**
     * @var DefaultValuePropertyTypeInferer
     */
    private $defaultValuePropertyTypeInferer;
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    /**
     * @var DoctrineTypeAnalyzer
     */
    private $doctrineTypeAnalyzer;
    /**
     * @var VarDocPropertyTypeInferer
     */
    private $varDocPropertyTypeInferer;
    /**
     * @param PropertyTypeInfererInterface[] $propertyTypeInferers
     */
    public function __construct(array $propertyTypeInferers, \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer\DefaultValuePropertyTypeInferer $defaultValuePropertyTypeInferer, \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer\VarDocPropertyTypeInferer $varDocPropertyTypeInferer, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory, \_PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\DoctrineTypeAnalyzer $doctrineTypeAnalyzer)
    {
        $this->propertyTypeInferers = $this->sortTypeInferersByPriority($propertyTypeInferers);
        $this->defaultValuePropertyTypeInferer = $defaultValuePropertyTypeInferer;
        $this->typeFactory = $typeFactory;
        $this->doctrineTypeAnalyzer = $doctrineTypeAnalyzer;
        $this->varDocPropertyTypeInferer = $varDocPropertyTypeInferer;
    }
    public function inferProperty(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $resolvedTypes = [];
        foreach ($this->propertyTypeInferers as $propertyTypeInferer) {
            $type = $propertyTypeInferer->inferProperty($property);
            if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\VoidType || $type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
                continue;
            }
            $resolvedTypes[] = $type;
        }
        // if nothing is clear from variable use, we use @var doc as fallback
        if ($resolvedTypes !== []) {
            $resolvedType = $this->typeFactory->createMixedPassedOrUnionType($resolvedTypes);
        } else {
            $resolvedType = $this->varDocPropertyTypeInferer->inferProperty($property);
        }
        // default value type must be added to each resolved type if set
        // @todo include in one of inferrers above
        $propertyDefaultValue = $property->props[0]->default;
        if ($propertyDefaultValue !== null) {
            $defaultValueType = $this->defaultValuePropertyTypeInferer->inferProperty($property);
            if ($this->shouldUnionWithDefaultValue($defaultValueType, $resolvedType)) {
                return $this->unionWithDefaultValueType($defaultValueType, $resolvedType);
            }
        }
        if ($resolvedType === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        return $resolvedType;
    }
    private function shouldUnionWithDefaultValue(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $defaultValueType, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type = null) : bool
    {
        if ($defaultValueType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
            return \false;
        }
        // skip empty array type (mixed[])
        if ($defaultValueType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType && $defaultValueType->getItemType() instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NeverType && $type !== null) {
            return \false;
        }
        if ($type === null) {
            return \true;
        }
        return !$this->doctrineTypeAnalyzer->isDoctrineCollectionWithIterableUnionType($type);
    }
    private function unionWithDefaultValueType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $defaultValueType, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $resolvedType) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $types = [];
        $types[] = $defaultValueType;
        if ($resolvedType !== null) {
            $types[] = $resolvedType;
        }
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
}
