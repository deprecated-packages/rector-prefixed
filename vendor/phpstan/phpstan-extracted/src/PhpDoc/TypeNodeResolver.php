<?php

declare (strict_types=1);
namespace PHPStan\PhpDoc;

use _HumbugBox221ad6f1b81f\Nette\Utils\Strings;
use PHPStan\Analyser\NameScope;
use PHPStan\DependencyInjection\Container;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode;
use PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode;
use PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use PHPStan\PhpDocParser\Ast\Type\CallableTypeNode;
use PHPStan\PhpDocParser\Ast\Type\CallableTypeParameterNode;
use PHPStan\PhpDocParser\Ast\Type\ConstTypeNode;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode;
use PHPStan\PhpDocParser\Ast\Type\NullableTypeNode;
use PHPStan\PhpDocParser\Ast\Type\ThisTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use PHPStan\Reflection\Native\NativeParameterReflection;
use PHPStan\Reflection\PassedByReference;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\Accessory\AccessoryNumericStringType;
use PHPStan\Type\Accessory\NonEmptyArrayType;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BenevolentUnionType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\CallableType;
use PHPStan\Type\ClassStringType;
use PHPStan\Type\ClosureType;
use PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\ConstantTypeHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\FloatType;
use PHPStan\Type\Generic\GenericClassStringType;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\IntegerRangeType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\IterableType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NeverType;
use PHPStan\Type\NonexistentParentClassType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\ResourceType;
use PHPStan\Type\StaticType;
use PHPStan\Type\StringType;
use PHPStan\Type\ThisType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\UnionType;
use PHPStan\Type\VoidType;
class TypeNodeResolver
{
    /** @var TypeNodeResolverExtensionRegistryProvider */
    private $extensionRegistryProvider;
    /** @var Container */
    private $container;
    public function __construct(\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistryProvider $extensionRegistryProvider, \PHPStan\DependencyInjection\Container $container)
    {
        $this->extensionRegistryProvider = $extensionRegistryProvider;
        $this->container = $container;
    }
    public function resolve(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \PHPStan\Analyser\NameScope $nameScope) : \PHPStan\Type\Type
    {
        foreach ($this->extensionRegistryProvider->getRegistry()->getExtensions() as $extension) {
            $type = $extension->resolve($typeNode, $nameScope);
            if ($type !== null) {
                return $type;
            }
        }
        if ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return $this->resolveIdentifierTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\ThisTypeNode) {
            return $this->resolveThisTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\NullableTypeNode) {
            return $this->resolveNullableTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            return $this->resolveUnionTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode) {
            return $this->resolveIntersectionTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode) {
            return $this->resolveArrayTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\GenericTypeNode) {
            return $this->resolveGenericTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\CallableTypeNode) {
            return $this->resolveCallableTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode) {
            return $this->resolveArrayShapeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\ConstTypeNode) {
            return $this->resolveConstTypeNode($typeNode, $nameScope);
        }
        return new \PHPStan\Type\ErrorType();
    }
    private function resolveIdentifierTypeNode(\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode $typeNode, \PHPStan\Analyser\NameScope $nameScope) : \PHPStan\Type\Type
    {
        switch (\strtolower($typeNode->name)) {
            case 'int':
            case 'integer':
                return new \PHPStan\Type\IntegerType();
            case 'positive-int':
                return \PHPStan\Type\IntegerRangeType::fromInterval(1, null);
            case 'negative-int':
                return \PHPStan\Type\IntegerRangeType::fromInterval(null, -1);
            case 'string':
                return new \PHPStan\Type\StringType();
            case 'class-string':
                return new \PHPStan\Type\ClassStringType();
            case 'callable-string':
                return new \PHPStan\Type\IntersectionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\CallableType()]);
            case 'array-key':
                return new \PHPStan\Type\BenevolentUnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()]);
            case 'scalar':
                return new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\FloatType(), new \PHPStan\Type\StringType(), new \PHPStan\Type\BooleanType()]);
            case 'number':
                return new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\FloatType()]);
            case 'numeric':
                return new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\FloatType(), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\Accessory\AccessoryNumericStringType()])]);
            case 'numeric-string':
                return new \PHPStan\Type\IntersectionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\Accessory\AccessoryNumericStringType()]);
            case 'bool':
            case 'boolean':
                return new \PHPStan\Type\BooleanType();
            case 'true':
                return new \PHPStan\Type\Constant\ConstantBooleanType(\true);
            case 'false':
                return new \PHPStan\Type\Constant\ConstantBooleanType(\false);
            case 'null':
                return new \PHPStan\Type\NullType();
            case 'float':
            case 'double':
                return new \PHPStan\Type\FloatType();
            case 'array':
            case 'associative-array':
                return new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
            case 'non-empty-array':
                return \PHPStan\Type\TypeCombinator::intersect(new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\Accessory\NonEmptyArrayType());
            case 'iterable':
                return new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
            case 'callable':
                return new \PHPStan\Type\CallableType();
            case 'resource':
                return new \PHPStan\Type\ResourceType();
            case 'mixed':
                return new \PHPStan\Type\MixedType(\true);
            case 'void':
                return new \PHPStan\Type\VoidType();
            case 'object':
                return new \PHPStan\Type\ObjectWithoutClassType();
            case 'never':
            case 'never-return':
            case 'never-returns':
            case 'no-return':
                return new \PHPStan\Type\NeverType(\true);
            case 'list':
                return new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\MixedType());
            case 'non-empty-list':
                return \PHPStan\Type\TypeCombinator::intersect(new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\Accessory\NonEmptyArrayType());
        }
        if ($nameScope->getClassName() !== null) {
            switch (\strtolower($typeNode->name)) {
                case 'self':
                    return new \PHPStan\Type\ObjectType($nameScope->getClassName());
                case 'static':
                    return new \PHPStan\Type\StaticType($nameScope->getClassName());
                case 'parent':
                    if ($this->getReflectionProvider()->hasClass($nameScope->getClassName())) {
                        $classReflection = $this->getReflectionProvider()->getClass($nameScope->getClassName());
                        if ($classReflection->getParentClass() !== \false) {
                            return new \PHPStan\Type\ObjectType($classReflection->getParentClass()->getName());
                        }
                    }
                    return new \PHPStan\Type\NonexistentParentClassType();
            }
        }
        $templateType = $nameScope->resolveTemplateTypeName($typeNode->name);
        if ($templateType !== null) {
            return $templateType;
        }
        $stringName = $nameScope->resolveStringName($typeNode->name);
        if (\strpos($stringName, '-') !== \false && \strpos($stringName, 'OCI-') !== 0) {
            return new \PHPStan\Type\ErrorType();
        }
        return new \PHPStan\Type\ObjectType($stringName);
    }
    private function resolveThisTypeNode(\PHPStan\PhpDocParser\Ast\Type\ThisTypeNode $typeNode, \PHPStan\Analyser\NameScope $nameScope) : \PHPStan\Type\Type
    {
        $className = $nameScope->getClassName();
        if ($className !== null) {
            if ($this->getReflectionProvider()->hasClass($className)) {
                return new \PHPStan\Type\ThisType($this->getReflectionProvider()->getClass($className));
            }
        }
        return new \PHPStan\Type\ErrorType();
    }
    private function resolveNullableTypeNode(\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode $typeNode, \PHPStan\Analyser\NameScope $nameScope) : \PHPStan\Type\Type
    {
        return \PHPStan\Type\TypeCombinator::addNull($this->resolve($typeNode->type, $nameScope));
    }
    private function resolveUnionTypeNode(\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode $typeNode, \PHPStan\Analyser\NameScope $nameScope) : \PHPStan\Type\Type
    {
        $iterableTypeNodes = [];
        $otherTypeNodes = [];
        foreach ($typeNode->types as $innerTypeNode) {
            if ($innerTypeNode instanceof \PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode) {
                $iterableTypeNodes[] = $innerTypeNode->type;
            } else {
                $otherTypeNodes[] = $innerTypeNode;
            }
        }
        $otherTypeTypes = $this->resolveMultiple($otherTypeNodes, $nameScope);
        if (\count($iterableTypeNodes) > 0) {
            $arrayTypeTypes = $this->resolveMultiple($iterableTypeNodes, $nameScope);
            $arrayTypeType = \PHPStan\Type\TypeCombinator::union(...$arrayTypeTypes);
            $addArray = \true;
            foreach ($otherTypeTypes as &$type) {
                if (!$type->isIterable()->yes() || !$type->getIterableValueType()->isSuperTypeOf($arrayTypeType)->yes()) {
                    continue;
                }
                if ($type instanceof \PHPStan\Type\ObjectType) {
                    $type = new \PHPStan\Type\IntersectionType([$type, new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), $arrayTypeType)]);
                } elseif ($type instanceof \PHPStan\Type\ArrayType) {
                    $type = new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), $arrayTypeType);
                } elseif ($type instanceof \PHPStan\Type\IterableType) {
                    $type = new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), $arrayTypeType);
                } else {
                    continue;
                }
                $addArray = \false;
            }
            if ($addArray) {
                $otherTypeTypes[] = new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), $arrayTypeType);
            }
        }
        return \PHPStan\Type\TypeCombinator::union(...$otherTypeTypes);
    }
    private function resolveIntersectionTypeNode(\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode $typeNode, \PHPStan\Analyser\NameScope $nameScope) : \PHPStan\Type\Type
    {
        $types = $this->resolveMultiple($typeNode->types, $nameScope);
        return \PHPStan\Type\TypeCombinator::intersect(...$types);
    }
    private function resolveArrayTypeNode(\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode $typeNode, \PHPStan\Analyser\NameScope $nameScope) : \PHPStan\Type\Type
    {
        $itemType = $this->resolve($typeNode->type, $nameScope);
        return new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), $itemType);
    }
    private function resolveGenericTypeNode(\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode $typeNode, \PHPStan\Analyser\NameScope $nameScope) : \PHPStan\Type\Type
    {
        $mainTypeName = \strtolower($typeNode->type->name);
        $genericTypes = $this->resolveMultiple($typeNode->genericTypes, $nameScope);
        if ($mainTypeName === 'array' || $mainTypeName === 'non-empty-array') {
            if (\count($genericTypes) === 1) {
                // array<ValueType>
                $arrayType = new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(\true), $genericTypes[0]);
            } elseif (\count($genericTypes) === 2) {
                // array<KeyType, ValueType>
                $arrayType = new \PHPStan\Type\ArrayType($genericTypes[0], $genericTypes[1]);
            } else {
                return new \PHPStan\Type\ErrorType();
            }
            if ($mainTypeName === 'non-empty-array') {
                return \PHPStan\Type\TypeCombinator::intersect($arrayType, new \PHPStan\Type\Accessory\NonEmptyArrayType());
            }
            return $arrayType;
        } elseif ($mainTypeName === 'list' || $mainTypeName === 'non-empty-list') {
            if (\count($genericTypes) === 1) {
                // list<ValueType>
                $listType = new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), $genericTypes[0]);
                if ($mainTypeName === 'non-empty-list') {
                    return \PHPStan\Type\TypeCombinator::intersect($listType, new \PHPStan\Type\Accessory\NonEmptyArrayType());
                }
                return $listType;
            }
            return new \PHPStan\Type\ErrorType();
        } elseif ($mainTypeName === 'iterable') {
            if (\count($genericTypes) === 1) {
                // iterable<ValueType>
                return new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(\true), $genericTypes[0]);
            }
            if (\count($genericTypes) === 2) {
                // iterable<KeyType, ValueType>
                return new \PHPStan\Type\IterableType($genericTypes[0], $genericTypes[1]);
            }
        } elseif ($mainTypeName === 'class-string') {
            if (\count($genericTypes) === 1) {
                $genericType = $genericTypes[0];
                if ((new \PHPStan\Type\ObjectWithoutClassType())->isSuperTypeOf($genericType)->yes() || $genericType instanceof \PHPStan\Type\MixedType) {
                    return new \PHPStan\Type\Generic\GenericClassStringType($genericType);
                }
            }
            return new \PHPStan\Type\ErrorType();
        }
        $mainType = $this->resolveIdentifierTypeNode($typeNode->type, $nameScope);
        if ($mainType instanceof \PHPStan\Type\TypeWithClassName) {
            if (!$this->getReflectionProvider()->hasClass($mainType->getClassName())) {
                return new \PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), $genericTypes);
            }
            $classReflection = $this->getReflectionProvider()->getClass($mainType->getClassName());
            if ($classReflection->isGeneric()) {
                if (\in_array($mainType->getClassName(), [\Traversable::class, \IteratorAggregate::class, \Iterator::class], \true)) {
                    if (\count($genericTypes) === 1) {
                        return new \PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), [new \PHPStan\Type\MixedType(\true), $genericTypes[0]]);
                    }
                    if (\count($genericTypes) === 2) {
                        return new \PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), [$genericTypes[0], $genericTypes[1]]);
                    }
                }
                if ($mainType->getClassName() === \Generator::class) {
                    if (\count($genericTypes) === 1) {
                        $mixed = new \PHPStan\Type\MixedType(\true);
                        return new \PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), [$mixed, $genericTypes[0], $mixed, $mixed]);
                    }
                    if (\count($genericTypes) === 2) {
                        $mixed = new \PHPStan\Type\MixedType(\true);
                        return new \PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), [$genericTypes[0], $genericTypes[1], $mixed, $mixed]);
                    }
                }
                if (!$mainType->isIterable()->yes()) {
                    return new \PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), $genericTypes);
                }
                if (\count($genericTypes) !== 1 || $classReflection->getTemplateTypeMap()->count() === 1) {
                    return new \PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), $genericTypes);
                }
            }
        }
        if ($mainType->isIterable()->yes()) {
            if (\count($genericTypes) === 1) {
                // Foo<ValueType>
                return \PHPStan\Type\TypeCombinator::intersect($mainType, new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(\true), $genericTypes[0]));
            }
            if (\count($genericTypes) === 2) {
                // Foo<KeyType, ValueType>
                return \PHPStan\Type\TypeCombinator::intersect($mainType, new \PHPStan\Type\IterableType($genericTypes[0], $genericTypes[1]));
            }
        }
        if ($mainType instanceof \PHPStan\Type\TypeWithClassName) {
            return new \PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), $genericTypes);
        }
        return new \PHPStan\Type\ErrorType();
    }
    private function resolveCallableTypeNode(\PHPStan\PhpDocParser\Ast\Type\CallableTypeNode $typeNode, \PHPStan\Analyser\NameScope $nameScope) : \PHPStan\Type\Type
    {
        $mainType = $this->resolve($typeNode->identifier, $nameScope);
        $isVariadic = \false;
        $parameters = \array_map(function (\PHPStan\PhpDocParser\Ast\Type\CallableTypeParameterNode $parameterNode) use($nameScope, &$isVariadic) : NativeParameterReflection {
            $isVariadic = $isVariadic || $parameterNode->isVariadic;
            $parameterName = $parameterNode->parameterName;
            if (\strpos($parameterName, '$') === 0) {
                $parameterName = \substr($parameterName, 1);
            }
            return new \PHPStan\Reflection\Native\NativeParameterReflection($parameterName, $parameterNode->isOptional || $parameterNode->isVariadic, $this->resolve($parameterNode->type, $nameScope), $parameterNode->isReference ? \PHPStan\Reflection\PassedByReference::createCreatesNewVariable() : \PHPStan\Reflection\PassedByReference::createNo(), $parameterNode->isVariadic, null);
        }, $typeNode->parameters);
        $returnType = $this->resolve($typeNode->returnType, $nameScope);
        if ($mainType instanceof \PHPStan\Type\CallableType) {
            return new \PHPStan\Type\CallableType($parameters, $returnType, $isVariadic);
        } elseif ($mainType instanceof \PHPStan\Type\ObjectType && $mainType->getClassName() === \Closure::class) {
            return new \PHPStan\Type\ClosureType($parameters, $returnType, $isVariadic);
        }
        return new \PHPStan\Type\ErrorType();
    }
    private function resolveArrayShapeNode(\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode $typeNode, \PHPStan\Analyser\NameScope $nameScope) : \PHPStan\Type\Type
    {
        $builder = \PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
        foreach ($typeNode->items as $itemNode) {
            $offsetType = null;
            if ($itemNode->keyName instanceof \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode) {
                $offsetType = new \PHPStan\Type\Constant\ConstantIntegerType((int) $itemNode->keyName->value);
            } elseif ($itemNode->keyName instanceof \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
                $offsetType = new \PHPStan\Type\Constant\ConstantStringType($itemNode->keyName->name);
            } elseif ($itemNode->keyName instanceof \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode) {
                $offsetType = new \PHPStan\Type\Constant\ConstantStringType($itemNode->keyName->value);
            } elseif ($itemNode->keyName !== null) {
                throw new \PHPStan\ShouldNotHappenException('Unsupported key node type: ' . \get_class($itemNode->keyName));
            }
            $builder->setOffsetValueType($offsetType, $this->resolve($itemNode->valueType, $nameScope), $itemNode->optional);
        }
        return $builder->getArray();
    }
    private function resolveConstTypeNode(\PHPStan\PhpDocParser\Ast\Type\ConstTypeNode $typeNode, \PHPStan\Analyser\NameScope $nameScope) : \PHPStan\Type\Type
    {
        $constExpr = $typeNode->constExpr;
        if ($constExpr instanceof \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode) {
            throw new \PHPStan\ShouldNotHappenException();
            // we prefer array shapes
        }
        if ($constExpr instanceof \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode || $constExpr instanceof \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode || $constExpr instanceof \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode) {
            throw new \PHPStan\ShouldNotHappenException();
            // we prefer IdentifierTypeNode
        }
        if ($constExpr instanceof \PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode) {
            if ($constExpr->className === '') {
                throw new \PHPStan\ShouldNotHappenException();
                // global constant should get parsed as class name in IdentifierTypeNode
            }
            if ($nameScope->getClassName() !== null) {
                switch (\strtolower($constExpr->className)) {
                    case 'static':
                    case 'self':
                        $className = $nameScope->getClassName();
                        break;
                    case 'parent':
                        if ($this->getReflectionProvider()->hasClass($nameScope->getClassName())) {
                            $classReflection = $this->getReflectionProvider()->getClass($nameScope->getClassName());
                            if ($classReflection->getParentClass() === \false) {
                                return new \PHPStan\Type\ErrorType();
                            }
                            $className = $classReflection->getParentClass()->getName();
                        }
                }
            }
            if (!isset($className)) {
                $className = $nameScope->resolveStringName($constExpr->className);
            }
            if (!$this->getReflectionProvider()->hasClass($className)) {
                return new \PHPStan\Type\ErrorType();
            }
            $classReflection = $this->getReflectionProvider()->getClass($className);
            $constantName = $constExpr->name;
            if (\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::endsWith($constantName, '*')) {
                $constantNameStartsWith = \_HumbugBox221ad6f1b81f\Nette\Utils\Strings::substring($constantName, 0, \_HumbugBox221ad6f1b81f\Nette\Utils\Strings::length($constantName) - 1);
                $constantTypes = [];
                foreach ($classReflection->getNativeReflection()->getConstants() as $classConstantName => $constantValue) {
                    if (!\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::startsWith($classConstantName, $constantNameStartsWith)) {
                        continue;
                    }
                    $constantTypes[] = \PHPStan\Type\ConstantTypeHelper::getTypeFromValue($constantValue);
                }
                if (\count($constantTypes) === 0) {
                    return new \PHPStan\Type\ErrorType();
                }
                return \PHPStan\Type\TypeCombinator::union(...$constantTypes);
            }
            if (!$classReflection->hasConstant($constantName)) {
                return new \PHPStan\Type\ErrorType();
            }
            return $classReflection->getConstant($constantName)->getValueType();
        }
        if ($constExpr instanceof \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode) {
            return \PHPStan\Type\ConstantTypeHelper::getTypeFromValue((float) $constExpr->value);
        }
        if ($constExpr instanceof \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode) {
            return \PHPStan\Type\ConstantTypeHelper::getTypeFromValue((int) $constExpr->value);
        }
        if ($constExpr instanceof \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode) {
            return \PHPStan\Type\ConstantTypeHelper::getTypeFromValue($constExpr->value);
        }
        return new \PHPStan\Type\ErrorType();
    }
    /**
     * @param TypeNode[] $typeNodes
     * @param NameScope $nameScope
     * @return Type[]
     */
    public function resolveMultiple(array $typeNodes, \PHPStan\Analyser\NameScope $nameScope) : array
    {
        $types = [];
        foreach ($typeNodes as $typeNode) {
            $types[] = $this->resolve($typeNode, $nameScope);
        }
        return $types;
    }
    private function getReflectionProvider() : \PHPStan\Reflection\ReflectionProvider
    {
        return $this->container->getByType(\PHPStan\Reflection\ReflectionProvider::class);
    }
}
