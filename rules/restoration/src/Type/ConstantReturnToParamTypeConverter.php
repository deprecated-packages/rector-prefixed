<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Restoration\Type;

use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedYetException;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
final class ConstantReturnToParamTypeConverter
{
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
    }
    public function convert(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if (!$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType && !$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType) {
            return null;
        }
        return $this->unwrapConstantTypeToObjectType($type);
    }
    private function unwrapConstantTypeToObjectType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType) {
            return $this->unwrapConstantTypeToObjectType($type->getItemType());
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($type->getValue());
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            $types = [];
            foreach ($type->getTypes() as $unionedType) {
                $types[] = $this->unwrapConstantTypeToObjectType($unionedType);
            }
            return $this->typeFactory->createMixedPassedOrUnionType($types);
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedYetException();
    }
}
