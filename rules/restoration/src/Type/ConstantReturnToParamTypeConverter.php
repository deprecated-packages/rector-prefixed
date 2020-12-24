<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Restoration\Type;

use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedYetException;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
final class ConstantReturnToParamTypeConverter
{
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
    }
    public function convert(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if (!$type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType && !$type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType) {
            return null;
        }
        return $this->unwrapConstantTypeToObjectType($type);
    }
    private function unwrapConstantTypeToObjectType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType) {
            return $this->unwrapConstantTypeToObjectType($type->getItemType());
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($type->getValue());
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
            $types = [];
            foreach ($type->getTypes() as $unionedType) {
                $types[] = $this->unwrapConstantTypeToObjectType($unionedType);
            }
            return $this->typeFactory->createMixedPassedOrUnionType($types);
        }
        throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedYetException();
    }
}
