<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Broker\Broker;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeHelper;
use ReflectionNamedType;
use ReflectionType;
use ReflectionUnionType;
class TypehintHelper
{
    private static function getTypeObjectFromTypehint(string $typeString, ?string $selfClass) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        switch (\strtolower($typeString)) {
            case 'int':
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType();
            case 'bool':
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType();
            case 'false':
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType(\false);
            case 'string':
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType();
            case 'float':
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType();
            case 'array':
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType());
            case 'iterable':
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IterableType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType());
            case 'callable':
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\CallableType();
            case 'void':
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VoidType();
            case 'object':
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectWithoutClassType();
            case 'mixed':
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType(\true);
            case 'self':
                return $selfClass !== null ? new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($selfClass) : new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType();
            case 'parent':
                $broker = \_PhpScoper2a4e7ab1ecbc\PHPStan\Broker\Broker::getInstance();
                if ($selfClass !== null && $broker->hasClass($selfClass)) {
                    $classReflection = $broker->getClass($selfClass);
                    if ($classReflection->getParentClass() !== \false) {
                        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($classReflection->getParentClass()->getName());
                    }
                }
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NonexistentParentClassType();
            case 'static':
                return $selfClass !== null ? new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StaticType($selfClass) : new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType();
            case 'null':
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType();
            default:
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($typeString);
        }
    }
    public static function decideTypeFromReflection(?\ReflectionType $reflectionType, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $phpDocType = null, ?string $selfClass = null, bool $isVariadic = \false) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if ($reflectionType === null) {
            if ($isVariadic && $phpDocType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType) {
                $phpDocType = $phpDocType->getItemType();
            }
            return $phpDocType ?? new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
        }
        if ($reflectionType instanceof \ReflectionUnionType) {
            $type = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::union(...\array_map(static function (\ReflectionType $type) use($selfClass) : Type {
                return self::decideTypeFromReflection($type, null, $selfClass, \false);
            }, $reflectionType->getTypes()));
            return self::decideType($type, $phpDocType);
        }
        if (!$reflectionType instanceof \ReflectionNamedType) {
            throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException(\sprintf('Unexpected type: %s', \get_class($reflectionType)));
        }
        $reflectionTypeString = $reflectionType->getName();
        if (\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::endsWith(\strtolower($reflectionTypeString), '\\object')) {
            $reflectionTypeString = 'object';
        }
        if (\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::endsWith(\strtolower($reflectionTypeString), '\\mixed')) {
            $reflectionTypeString = 'mixed';
        }
        if (\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::endsWith(\strtolower($reflectionTypeString), '\\false')) {
            $reflectionTypeString = 'false';
        }
        if (\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::endsWith(\strtolower($reflectionTypeString), '\\null')) {
            $reflectionTypeString = 'null';
        }
        $type = self::getTypeObjectFromTypehint($reflectionTypeString, $selfClass);
        if ($reflectionType->allowsNull()) {
            $type = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::addNull($type);
        } elseif ($phpDocType !== null) {
            $phpDocType = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::removeNull($phpDocType);
        }
        return self::decideType($type, $phpDocType);
    }
    public static function decideType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $phpDocType = null) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if ($phpDocType !== null && !$phpDocType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType) {
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VoidType) {
                if ($phpDocType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NeverType && $phpDocType->isExplicit()) {
                    return $phpDocType;
                }
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VoidType();
            }
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType && !$type->isExplicitMixed() && $phpDocType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VoidType) {
                return $phpDocType;
            }
            if (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::removeNull($type) instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IterableType) {
                if ($phpDocType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType) {
                    $innerTypes = [];
                    foreach ($phpDocType->getTypes() as $innerType) {
                        if ($innerType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType) {
                            $innerTypes[] = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IterableType($innerType->getKeyType(), $innerType->getItemType());
                        } else {
                            $innerTypes[] = $innerType;
                        }
                    }
                    $phpDocType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType($innerTypes);
                } elseif ($phpDocType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType) {
                    $phpDocType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IterableType($phpDocType->getKeyType(), $phpDocType->getItemType());
                }
            }
            $resultType = $type->isSuperTypeOf(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($phpDocType))->yes() ? $phpDocType : $type;
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType) {
                $addToUnionTypes = [];
                foreach ($type->getTypes() as $innerType) {
                    if (!$innerType->isSuperTypeOf($resultType)->no()) {
                        continue;
                    }
                    $addToUnionTypes[] = $innerType;
                }
                if (\count($addToUnionTypes) > 0) {
                    $type = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::union($resultType, ...$addToUnionTypes);
                } else {
                    $type = $resultType;
                }
            } elseif (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::containsNull($type)) {
                $type = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::addNull($resultType);
            } else {
                $type = $resultType;
            }
        }
        return $type;
    }
}
