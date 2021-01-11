<?php

declare (strict_types=1);
namespace Rector\Restoration\Type;

use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\Core\Exception\NotImplementedYetException;
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
    public function convert(\PHPStan\Type\Type $type) : ?\PHPStan\Type\Type
    {
        if (!$type instanceof \PHPStan\Type\Constant\ConstantStringType && !$type instanceof \PHPStan\Type\Constant\ConstantArrayType) {
            return null;
        }
        return $this->unwrapConstantTypeToObjectType($type);
    }
    private function unwrapConstantTypeToObjectType(\PHPStan\Type\Type $type) : ?\PHPStan\Type\Type
    {
        if ($type instanceof \PHPStan\Type\Constant\ConstantArrayType) {
            return $this->unwrapConstantTypeToObjectType($type->getItemType());
        }
        if ($type instanceof \PHPStan\Type\Constant\ConstantStringType) {
            return new \PHPStan\Type\ObjectType($type->getValue());
        }
        if ($type instanceof \PHPStan\Type\UnionType) {
            $types = [];
            foreach ($type->getTypes() as $unionedType) {
                $type = $this->unwrapConstantTypeToObjectType($unionedType);
                if ($type !== null) {
                    $types[] = $type;
                }
            }
            return $this->typeFactory->createMixedPassedOrUnionType($types);
        }
        return null;
    }
}
