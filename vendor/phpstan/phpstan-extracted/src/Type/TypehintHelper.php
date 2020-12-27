<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Broker\Broker;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Generic\TemplateTypeHelper;
use ReflectionNamedType;
use ReflectionType;
use ReflectionUnionType;
class TypehintHelper
{
    private static function getTypeObjectFromTypehint(string $typeString, ?string $selfClass) : \PHPStan\Type\Type
    {
        switch (\strtolower($typeString)) {
            case 'int':
                return new \PHPStan\Type\IntegerType();
            case 'bool':
                return new \PHPStan\Type\BooleanType();
            case 'false':
                return new \PHPStan\Type\Constant\ConstantBooleanType(\false);
            case 'string':
                return new \PHPStan\Type\StringType();
            case 'float':
                return new \PHPStan\Type\FloatType();
            case 'array':
                return new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
            case 'iterable':
                return new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
            case 'callable':
                return new \PHPStan\Type\CallableType();
            case 'void':
                return new \PHPStan\Type\VoidType();
            case 'object':
                return new \PHPStan\Type\ObjectWithoutClassType();
            case 'mixed':
                return new \PHPStan\Type\MixedType(\true);
            case 'self':
                return $selfClass !== null ? new \PHPStan\Type\ObjectType($selfClass) : new \PHPStan\Type\ErrorType();
            case 'parent':
                $broker = \PHPStan\Broker\Broker::getInstance();
                if ($selfClass !== null && $broker->hasClass($selfClass)) {
                    $classReflection = $broker->getClass($selfClass);
                    if ($classReflection->getParentClass() !== \false) {
                        return new \PHPStan\Type\ObjectType($classReflection->getParentClass()->getName());
                    }
                }
                return new \PHPStan\Type\NonexistentParentClassType();
            case 'static':
                return $selfClass !== null ? new \PHPStan\Type\StaticType($selfClass) : new \PHPStan\Type\ErrorType();
            case 'null':
                return new \PHPStan\Type\NullType();
            default:
                return new \PHPStan\Type\ObjectType($typeString);
        }
    }
    public static function decideTypeFromReflection(?\ReflectionType $reflectionType, ?\PHPStan\Type\Type $phpDocType = null, ?string $selfClass = null, bool $isVariadic = \false) : \PHPStan\Type\Type
    {
        if ($reflectionType === null) {
            if ($isVariadic && $phpDocType instanceof \PHPStan\Type\ArrayType) {
                $phpDocType = $phpDocType->getItemType();
            }
            return $phpDocType ?? new \PHPStan\Type\MixedType();
        }
        if ($reflectionType instanceof \ReflectionUnionType) {
            $type = \PHPStan\Type\TypeCombinator::union(...\array_map(static function (\ReflectionType $type) use($selfClass) : Type {
                return self::decideTypeFromReflection($type, null, $selfClass, \false);
            }, $reflectionType->getTypes()));
            return self::decideType($type, $phpDocType);
        }
        if (!$reflectionType instanceof \ReflectionNamedType) {
            throw new \PHPStan\ShouldNotHappenException(\sprintf('Unexpected type: %s', \get_class($reflectionType)));
        }
        $reflectionTypeString = $reflectionType->getName();
        if (\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::endsWith(\strtolower($reflectionTypeString), '\\object')) {
            $reflectionTypeString = 'object';
        }
        if (\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::endsWith(\strtolower($reflectionTypeString), '\\mixed')) {
            $reflectionTypeString = 'mixed';
        }
        if (\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::endsWith(\strtolower($reflectionTypeString), '\\false')) {
            $reflectionTypeString = 'false';
        }
        if (\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::endsWith(\strtolower($reflectionTypeString), '\\null')) {
            $reflectionTypeString = 'null';
        }
        $type = self::getTypeObjectFromTypehint($reflectionTypeString, $selfClass);
        if ($reflectionType->allowsNull()) {
            $type = \PHPStan\Type\TypeCombinator::addNull($type);
        } elseif ($phpDocType !== null) {
            $phpDocType = \PHPStan\Type\TypeCombinator::removeNull($phpDocType);
        }
        return self::decideType($type, $phpDocType);
    }
    public static function decideType(\PHPStan\Type\Type $type, ?\PHPStan\Type\Type $phpDocType = null) : \PHPStan\Type\Type
    {
        if ($phpDocType !== null && !$phpDocType instanceof \PHPStan\Type\ErrorType) {
            if ($type instanceof \PHPStan\Type\VoidType) {
                if ($phpDocType instanceof \PHPStan\Type\NeverType && $phpDocType->isExplicit()) {
                    return $phpDocType;
                }
                return new \PHPStan\Type\VoidType();
            }
            if ($type instanceof \PHPStan\Type\MixedType && !$type->isExplicitMixed() && $phpDocType instanceof \PHPStan\Type\VoidType) {
                return $phpDocType;
            }
            if (\PHPStan\Type\TypeCombinator::removeNull($type) instanceof \PHPStan\Type\IterableType) {
                if ($phpDocType instanceof \PHPStan\Type\UnionType) {
                    $innerTypes = [];
                    foreach ($phpDocType->getTypes() as $innerType) {
                        if ($innerType instanceof \PHPStan\Type\ArrayType) {
                            $innerTypes[] = new \PHPStan\Type\IterableType($innerType->getKeyType(), $innerType->getItemType());
                        } else {
                            $innerTypes[] = $innerType;
                        }
                    }
                    $phpDocType = new \PHPStan\Type\UnionType($innerTypes);
                } elseif ($phpDocType instanceof \PHPStan\Type\ArrayType) {
                    $phpDocType = new \PHPStan\Type\IterableType($phpDocType->getKeyType(), $phpDocType->getItemType());
                }
            }
            $resultType = $type->isSuperTypeOf(\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($phpDocType))->yes() ? $phpDocType : $type;
            if ($type instanceof \PHPStan\Type\UnionType) {
                $addToUnionTypes = [];
                foreach ($type->getTypes() as $innerType) {
                    if (!$innerType->isSuperTypeOf($resultType)->no()) {
                        continue;
                    }
                    $addToUnionTypes[] = $innerType;
                }
                if (\count($addToUnionTypes) > 0) {
                    $type = \PHPStan\Type\TypeCombinator::union($resultType, ...$addToUnionTypes);
                } else {
                    $type = $resultType;
                }
            } elseif (\PHPStan\Type\TypeCombinator::containsNull($type)) {
                $type = \PHPStan\Type\TypeCombinator::addNull($resultType);
            } else {
                $type = $resultType;
            }
        }
        return $type;
    }
}
