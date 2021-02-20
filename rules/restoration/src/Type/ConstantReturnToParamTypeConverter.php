<?php

declare (strict_types=1);
namespace Rector\Restoration\Type;

use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\Generic\GenericClassStringType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
final class ConstantReturnToParamTypeConverter
{
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
    }
    public function convert(\PHPStan\Type\Type $type) : \PHPStan\Type\Type
    {
        if (!$type instanceof \PHPStan\Type\Constant\ConstantStringType && !$type instanceof \PHPStan\Type\Constant\ConstantArrayType) {
            return new \PHPStan\Type\MixedType();
        }
        return $this->unwrapConstantTypeToObjectType($type);
    }
    private function unwrapConstantTypeToObjectType(\PHPStan\Type\Type $type) : \PHPStan\Type\Type
    {
        if ($type instanceof \PHPStan\Type\Constant\ConstantArrayType) {
            return $this->unwrapConstantTypeToObjectType($type->getItemType());
        }
        if ($type instanceof \PHPStan\Type\Constant\ConstantStringType) {
            return new \PHPStan\Type\ObjectType($type->getValue());
        }
        if ($type instanceof \PHPStan\Type\Generic\GenericClassStringType && $type->getGenericType() instanceof \PHPStan\Type\ObjectType) {
            return $type->getGenericType();
        }
        if ($type instanceof \PHPStan\Type\UnionType) {
            return $this->unwrapUnionType($type);
        }
        return new \PHPStan\Type\MixedType();
    }
    private function unwrapUnionType(\PHPStan\Type\UnionType $unionType) : \PHPStan\Type\Type
    {
        $types = [];
        foreach ($unionType->getTypes() as $unionedType) {
            $unionType = $this->unwrapConstantTypeToObjectType($unionedType);
            if ($unionType !== null) {
                $types[] = $unionType;
            }
        }
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
}
