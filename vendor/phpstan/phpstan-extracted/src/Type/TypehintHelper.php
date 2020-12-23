<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

use _PhpScoper0a2ac50786fa\PHPStan\Broker\Broker;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeHelper;
use ReflectionNamedType;
use ReflectionType;
use ReflectionUnionType;
class TypehintHelper
{
    private static function getTypeObjectFromTypehint(string $typeString, ?string $selfClass) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        switch (\strtolower($typeString)) {
            case 'int':
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType();
            case 'bool':
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType();
            case 'false':
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\false);
            case 'string':
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType();
            case 'float':
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\FloatType();
            case 'array':
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType());
            case 'iterable':
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\IterableType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType());
            case 'callable':
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\CallableType();
            case 'void':
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType();
            case 'object':
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType();
            case 'mixed':
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType(\true);
            case 'self':
                return $selfClass !== null ? new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType($selfClass) : new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
            case 'parent':
                $broker = \_PhpScoper0a2ac50786fa\PHPStan\Broker\Broker::getInstance();
                if ($selfClass !== null && $broker->hasClass($selfClass)) {
                    $classReflection = $broker->getClass($selfClass);
                    if ($classReflection->getParentClass() !== \false) {
                        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType($classReflection->getParentClass()->getName());
                    }
                }
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\NonexistentParentClassType();
            case 'static':
                return $selfClass !== null ? new \_PhpScoper0a2ac50786fa\PHPStan\Type\StaticType($selfClass) : new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
            case 'null':
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\NullType();
            default:
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType($typeString);
        }
    }
    public static function decideTypeFromReflection(?\ReflectionType $reflectionType, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $phpDocType = null, ?string $selfClass = null, bool $isVariadic = \false) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($reflectionType === null) {
            if ($isVariadic && $phpDocType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
                $phpDocType = $phpDocType->getItemType();
            }
            return $phpDocType ?? new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
        }
        if ($reflectionType instanceof \ReflectionUnionType) {
            $type = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(...\array_map(static function (\ReflectionType $type) use($selfClass) : Type {
                return self::decideTypeFromReflection($type, null, $selfClass, \false);
            }, $reflectionType->getTypes()));
            return self::decideType($type, $phpDocType);
        }
        if (!$reflectionType instanceof \ReflectionNamedType) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException(\sprintf('Unexpected type: %s', \get_class($reflectionType)));
        }
        $reflectionTypeString = $reflectionType->getName();
        if (\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::endsWith(\strtolower($reflectionTypeString), '\\object')) {
            $reflectionTypeString = 'object';
        }
        if (\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::endsWith(\strtolower($reflectionTypeString), '\\mixed')) {
            $reflectionTypeString = 'mixed';
        }
        if (\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::endsWith(\strtolower($reflectionTypeString), '\\false')) {
            $reflectionTypeString = 'false';
        }
        if (\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::endsWith(\strtolower($reflectionTypeString), '\\null')) {
            $reflectionTypeString = 'null';
        }
        $type = self::getTypeObjectFromTypehint($reflectionTypeString, $selfClass);
        if ($reflectionType->allowsNull()) {
            $type = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::addNull($type);
        } elseif ($phpDocType !== null) {
            $phpDocType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::removeNull($phpDocType);
        }
        return self::decideType($type, $phpDocType);
    }
    public static function decideType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $phpDocType = null) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($phpDocType !== null && !$phpDocType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType) {
            if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType) {
                if ($phpDocType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType && $phpDocType->isExplicit()) {
                    return $phpDocType;
                }
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType();
            }
            if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType && !$type->isExplicitMixed() && $phpDocType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType) {
                return $phpDocType;
            }
            if (\_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::removeNull($type) instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IterableType) {
                if ($phpDocType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
                    $innerTypes = [];
                    foreach ($phpDocType->getTypes() as $innerType) {
                        if ($innerType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
                            $innerTypes[] = new \_PhpScoper0a2ac50786fa\PHPStan\Type\IterableType($innerType->getKeyType(), $innerType->getItemType());
                        } else {
                            $innerTypes[] = $innerType;
                        }
                    }
                    $phpDocType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType($innerTypes);
                } elseif ($phpDocType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
                    $phpDocType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\IterableType($phpDocType->getKeyType(), $phpDocType->getItemType());
                }
            }
            $resultType = $type->isSuperTypeOf(\_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($phpDocType))->yes() ? $phpDocType : $type;
            if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
                $addToUnionTypes = [];
                foreach ($type->getTypes() as $innerType) {
                    if (!$innerType->isSuperTypeOf($resultType)->no()) {
                        continue;
                    }
                    $addToUnionTypes[] = $innerType;
                }
                if (\count($addToUnionTypes) > 0) {
                    $type = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union($resultType, ...$addToUnionTypes);
                } else {
                    $type = $resultType;
                }
            } elseif (\_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::containsNull($type)) {
                $type = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::addNull($resultType);
            } else {
                $type = $resultType;
            }
        }
        return $type;
    }
}
