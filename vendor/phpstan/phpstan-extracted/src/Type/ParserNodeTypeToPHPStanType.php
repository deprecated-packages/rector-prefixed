<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type;

use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\NullableType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
class ParserNodeTypeToPHPStanType
{
    /**
     * @param \PhpParser\Node\Name|\PhpParser\Node\Identifier|\PhpParser\Node\NullableType|\PhpParser\Node\UnionType|null $type
     * @param string|null $className
     * @return Type
     */
    public static function resolve($type, ?string $className) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if ($type === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        } elseif ($type instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
            $typeClassName = (string) $type;
            $lowercasedClassName = \strtolower($typeClassName);
            if ($className !== null && \in_array($lowercasedClassName, ['self', 'static'], \true)) {
                $typeClassName = $className;
            } elseif ($lowercasedClassName === 'parent') {
                throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException('parent type is not supported here');
            }
            if ($lowercasedClassName === 'static') {
                return new \_PhpScoper0a6b37af0871\PHPStan\Type\StaticType($typeClassName);
            }
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($typeClassName);
        } elseif ($type instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\NullableType) {
            return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::addNull(self::resolve($type->type, $className));
        } elseif ($type instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\UnionType) {
            $types = [];
            foreach ($type->types as $unionTypeType) {
                $types[] = self::resolve($unionTypeType, $className);
            }
            return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...$types);
        }
        $type = $type->name;
        if ($type === 'string') {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType();
        } elseif ($type === 'int') {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType();
        } elseif ($type === 'bool') {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType();
        } elseif ($type === 'float') {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\FloatType();
        } elseif ($type === 'callable') {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\CallableType();
        } elseif ($type === 'array') {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType());
        } elseif ($type === 'iterable') {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType());
        } elseif ($type === 'void') {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\VoidType();
        } elseif ($type === 'object') {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType();
        } elseif ($type === 'false') {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false);
        } elseif ($type === 'null') {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType();
        } elseif ($type === 'mixed') {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(\true);
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
    }
}
