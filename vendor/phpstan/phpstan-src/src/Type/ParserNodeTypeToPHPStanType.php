<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PHPStan\Type\Constant\ConstantBooleanType;
class ParserNodeTypeToPHPStanType
{
    /**
     * @param \PhpParser\Node\Name|\PhpParser\Node\Identifier|\PhpParser\Node\NullableType|\PhpParser\Node\UnionType|null $type
     * @param string|null $className
     * @return Type
     */
    public static function resolve($type, ?string $className) : \PHPStan\Type\Type
    {
        if ($type === null) {
            return new \PHPStan\Type\MixedType();
        } elseif ($type instanceof \PhpParser\Node\Name) {
            $typeClassName = (string) $type;
            $lowercasedClassName = \strtolower($typeClassName);
            if ($className !== null && \in_array($lowercasedClassName, ['self', 'static'], \true)) {
                $typeClassName = $className;
            } elseif ($lowercasedClassName === 'parent') {
                throw new \PHPStan\ShouldNotHappenException('parent type is not supported here');
            }
            if ($lowercasedClassName === 'static') {
                return new \PHPStan\Type\StaticType($typeClassName);
            }
            return new \PHPStan\Type\ObjectType($typeClassName);
        } elseif ($type instanceof \PhpParser\Node\NullableType) {
            return \PHPStan\Type\TypeCombinator::addNull(self::resolve($type->type, $className));
        } elseif ($type instanceof \PhpParser\Node\UnionType) {
            $types = [];
            foreach ($type->types as $unionTypeType) {
                $types[] = self::resolve($unionTypeType, $className);
            }
            return \PHPStan\Type\TypeCombinator::union(...$types);
        }
        $type = $type->name;
        if ($type === 'string') {
            return new \PHPStan\Type\StringType();
        } elseif ($type === 'int') {
            return new \PHPStan\Type\IntegerType();
        } elseif ($type === 'bool') {
            return new \PHPStan\Type\BooleanType();
        } elseif ($type === 'float') {
            return new \PHPStan\Type\FloatType();
        } elseif ($type === 'callable') {
            return new \PHPStan\Type\CallableType();
        } elseif ($type === 'array') {
            return new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
        } elseif ($type === 'iterable') {
            return new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
        } elseif ($type === 'void') {
            return new \PHPStan\Type\VoidType();
        } elseif ($type === 'object') {
            return new \PHPStan\Type\ObjectWithoutClassType();
        } elseif ($type === 'false') {
            return new \PHPStan\Type\Constant\ConstantBooleanType(\false);
        } elseif ($type === 'null') {
            return new \PHPStan\Type\NullType();
        } elseif ($type === 'mixed') {
            return new \PHPStan\Type\MixedType(\true);
        }
        return new \PHPStan\Type\MixedType();
    }
}
