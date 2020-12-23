<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Restoration\Type;

use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\NotImplementedYetException;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
final class ConstantReturnToParamTypeConverter
{
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
    }
    public function convert(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if (!$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType && !$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType) {
            return null;
        }
        return $this->unwrapConstantTypeToObjectType($type);
    }
    private function unwrapConstantTypeToObjectType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType) {
            return $this->unwrapConstantTypeToObjectType($type->getItemType());
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType($type->getValue());
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
            $types = [];
            foreach ($type->getTypes() as $unionedType) {
                $types[] = $this->unwrapConstantTypeToObjectType($unionedType);
            }
            return $this->typeFactory->createMixedPassedOrUnionType($types);
        }
        throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\NotImplementedYetException();
    }
}
