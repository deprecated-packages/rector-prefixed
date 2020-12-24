<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Restoration\Type;

use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedYetException;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
final class ConstantReturnToParamTypeConverter
{
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
    }
    public function convert(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType && !$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType) {
            return null;
        }
        return $this->unwrapConstantTypeToObjectType($type);
    }
    private function unwrapConstantTypeToObjectType(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType) {
            return $this->unwrapConstantTypeToObjectType($type->getItemType());
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($type->getValue());
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            $types = [];
            foreach ($type->getTypes() as $unionedType) {
                $types[] = $this->unwrapConstantTypeToObjectType($unionedType);
            }
            return $this->typeFactory->createMixedPassedOrUnionType($types);
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedYetException();
    }
}
