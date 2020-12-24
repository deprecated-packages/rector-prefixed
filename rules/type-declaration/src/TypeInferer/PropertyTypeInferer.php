<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\NeverType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\VoidType;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\DoctrineTypeAnalyzer;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer\DefaultValuePropertyTypeInferer;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer\VarDocPropertyTypeInferer;
final class PropertyTypeInferer extends \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\AbstractPriorityAwareTypeInferer
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
    public function __construct(array $propertyTypeInferers, \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer\DefaultValuePropertyTypeInferer $defaultValuePropertyTypeInferer, \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer\VarDocPropertyTypeInferer $varDocPropertyTypeInferer, \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory, \_PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\DoctrineTypeAnalyzer $doctrineTypeAnalyzer)
    {
        $this->propertyTypeInferers = $this->sortTypeInferersByPriority($propertyTypeInferers);
        $this->defaultValuePropertyTypeInferer = $defaultValuePropertyTypeInferer;
        $this->typeFactory = $typeFactory;
        $this->doctrineTypeAnalyzer = $doctrineTypeAnalyzer;
        $this->varDocPropertyTypeInferer = $varDocPropertyTypeInferer;
    }
    public function inferProperty(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property $property) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $resolvedTypes = [];
        foreach ($this->propertyTypeInferers as $propertyTypeInferer) {
            $type = $propertyTypeInferer->inferProperty($property);
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VoidType || $type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType) {
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
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
        }
        return $resolvedType;
    }
    private function shouldUnionWithDefaultValue(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $defaultValueType, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type = null) : bool
    {
        if ($defaultValueType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType) {
            return \false;
        }
        // skip empty array type (mixed[])
        if ($defaultValueType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType && $defaultValueType->getItemType() instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NeverType && $type !== null) {
            return \false;
        }
        if ($type === null) {
            return \true;
        }
        return !$this->doctrineTypeAnalyzer->isDoctrineCollectionWithIterableUnionType($type);
    }
    private function unionWithDefaultValueType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $defaultValueType, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $resolvedType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $types = [];
        $types[] = $defaultValueType;
        if ($resolvedType !== null) {
            $types[] = $resolvedType;
        }
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
}
