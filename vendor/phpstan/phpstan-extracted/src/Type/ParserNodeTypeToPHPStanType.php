<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\NullableType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
class ParserNodeTypeToPHPStanType
{
    /**
     * @param \PhpParser\Node\Name|\PhpParser\Node\Identifier|\PhpParser\Node\NullableType|\PhpParser\Node\UnionType|null $type
     * @param string|null $className
     * @return Type
     */
    public static function resolve($type, ?string $className) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($type === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        } elseif ($type instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            $typeClassName = (string) $type;
            $lowercasedClassName = \strtolower($typeClassName);
            if ($className !== null && \in_array($lowercasedClassName, ['self', 'static'], \true)) {
                $typeClassName = $className;
            } elseif ($lowercasedClassName === 'parent') {
                throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException('parent type is not supported here');
            }
            if ($lowercasedClassName === 'static') {
                return new \_PhpScopere8e811afab72\PHPStan\Type\StaticType($typeClassName);
            }
            return new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($typeClassName);
        } elseif ($type instanceof \_PhpScopere8e811afab72\PhpParser\Node\NullableType) {
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::addNull(self::resolve($type->type, $className));
        } elseif ($type instanceof \_PhpScopere8e811afab72\PhpParser\Node\UnionType) {
            $types = [];
            foreach ($type->types as $unionTypeType) {
                $types[] = self::resolve($unionTypeType, $className);
            }
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...$types);
        }
        $type = $type->name;
        if ($type === 'string') {
            return new \_PhpScopere8e811afab72\PHPStan\Type\StringType();
        } elseif ($type === 'int') {
            return new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType();
        } elseif ($type === 'bool') {
            return new \_PhpScopere8e811afab72\PHPStan\Type\BooleanType();
        } elseif ($type === 'float') {
            return new \_PhpScopere8e811afab72\PHPStan\Type\FloatType();
        } elseif ($type === 'callable') {
            return new \_PhpScopere8e811afab72\PHPStan\Type\CallableType();
        } elseif ($type === 'array') {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
        } elseif ($type === 'iterable') {
            return new \_PhpScopere8e811afab72\PHPStan\Type\IterableType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
        } elseif ($type === 'void') {
            return new \_PhpScopere8e811afab72\PHPStan\Type\VoidType();
        } elseif ($type === 'object') {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType();
        } elseif ($type === 'false') {
            return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false);
        } elseif ($type === 'null') {
            return new \_PhpScopere8e811afab72\PHPStan\Type\NullType();
        } elseif ($type === 'mixed') {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(\true);
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
}
