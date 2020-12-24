<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\PhpDoc;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope;
use _PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Container;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\CallableTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\CallableTypeParameterNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ConstTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ThisTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Native\NativeParameterReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PassedByReference;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Type\Accessory\AccessoryNumericStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\BenevolentUnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\CallableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ClosureType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ConstantTypeHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\FloatType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericClassStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerRangeType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IterableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NeverType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NonexistentParentClassType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ResourceType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StaticType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ThisType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VoidType;
class TypeNodeResolver
{
    /** @var TypeNodeResolverExtensionRegistryProvider */
    private $extensionRegistryProvider;
    /** @var Container */
    private $container;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistryProvider $extensionRegistryProvider, \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Container $container)
    {
        $this->extensionRegistryProvider = $extensionRegistryProvider;
        $this->container = $container;
    }
    public function resolve(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        foreach ($this->extensionRegistryProvider->getRegistry()->getExtensions() as $extension) {
            $type = $extension->resolve($typeNode, $nameScope);
            if ($type !== null) {
                return $type;
            }
        }
        if ($typeNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return $this->resolveIdentifierTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ThisTypeNode) {
            return $this->resolveThisTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode) {
            return $this->resolveNullableTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            return $this->resolveUnionTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode) {
            return $this->resolveIntersectionTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode) {
            return $this->resolveArrayTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode) {
            return $this->resolveGenericTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\CallableTypeNode) {
            return $this->resolveCallableTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode) {
            return $this->resolveArrayShapeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ConstTypeNode) {
            return $this->resolveConstTypeNode($typeNode, $nameScope);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
    }
    private function resolveIdentifierTypeNode(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode $typeNode, \_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        switch (\strtolower($typeNode->name)) {
            case 'int':
            case 'integer':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType();
            case 'positive-int':
                return \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerRangeType::fromInterval(1, null);
            case 'negative-int':
                return \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerRangeType::fromInterval(null, -1);
            case 'string':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType();
            case 'class-string':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType();
            case 'callable-string':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\CallableType()]);
            case 'array-key':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\BenevolentUnionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType()]);
            case 'scalar':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType()]);
            case 'number':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType()]);
            case 'numeric':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\AccessoryNumericStringType()])]);
            case 'numeric-string':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\AccessoryNumericStringType()]);
            case 'bool':
            case 'boolean':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType();
            case 'true':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\true);
            case 'false':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\false);
            case 'null':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType();
            case 'float':
            case 'double':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType();
            case 'array':
            case 'associative-array':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType());
            case 'non-empty-array':
                return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::intersect(new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType()), new \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\NonEmptyArrayType());
            case 'iterable':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType());
            case 'callable':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\CallableType();
            case 'resource':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\ResourceType();
            case 'mixed':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(\true);
            case 'void':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType();
            case 'object':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType();
            case 'never':
            case 'never-return':
            case 'never-returns':
            case 'no-return':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\NeverType(\true);
            case 'list':
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType());
            case 'non-empty-list':
                return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::intersect(new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType()), new \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\NonEmptyArrayType());
        }
        if ($nameScope->getClassName() !== null) {
            switch (\strtolower($typeNode->name)) {
                case 'self':
                    return new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($nameScope->getClassName());
                case 'static':
                    return new \_PhpScoperb75b35f52b74\PHPStan\Type\StaticType($nameScope->getClassName());
                case 'parent':
                    if ($this->getReflectionProvider()->hasClass($nameScope->getClassName())) {
                        $classReflection = $this->getReflectionProvider()->getClass($nameScope->getClassName());
                        if ($classReflection->getParentClass() !== \false) {
                            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($classReflection->getParentClass()->getName());
                        }
                    }
                    return new \_PhpScoperb75b35f52b74\PHPStan\Type\NonexistentParentClassType();
            }
        }
        $templateType = $nameScope->resolveTemplateTypeName($typeNode->name);
        if ($templateType !== null) {
            return $templateType;
        }
        $stringName = $nameScope->resolveStringName($typeNode->name);
        if (\strpos($stringName, '-') !== \false && \strpos($stringName, 'OCI-') !== 0) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($stringName);
    }
    private function resolveThisTypeNode(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ThisTypeNode $typeNode, \_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $className = $nameScope->getClassName();
        if ($className !== null) {
            if ($this->getReflectionProvider()->hasClass($className)) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\ThisType($this->getReflectionProvider()->getClass($className));
            }
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
    }
    private function resolveNullableTypeNode(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode $typeNode, \_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::addNull($this->resolve($typeNode->type, $nameScope));
    }
    private function resolveUnionTypeNode(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode $typeNode, \_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $iterableTypeNodes = [];
        $otherTypeNodes = [];
        foreach ($typeNode->types as $innerTypeNode) {
            if ($innerTypeNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode) {
                $iterableTypeNodes[] = $innerTypeNode->type;
            } else {
                $otherTypeNodes[] = $innerTypeNode;
            }
        }
        $otherTypeTypes = $this->resolveMultiple($otherTypeNodes, $nameScope);
        if (\count($iterableTypeNodes) > 0) {
            $arrayTypeTypes = $this->resolveMultiple($iterableTypeNodes, $nameScope);
            $arrayTypeType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...$arrayTypeTypes);
            $addArray = \true;
            foreach ($otherTypeTypes as &$type) {
                if (!$type->isIterable()->yes() || !$type->getIterableValueType()->isSuperTypeOf($arrayTypeType)->yes()) {
                    continue;
                }
                if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
                    $type = new \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType([$type, new \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), $arrayTypeType)]);
                } elseif ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType) {
                    $type = new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), $arrayTypeType);
                } elseif ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType) {
                    $type = new \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), $arrayTypeType);
                } else {
                    continue;
                }
                $addArray = \false;
            }
            if ($addArray) {
                $otherTypeTypes[] = new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), $arrayTypeType);
            }
        }
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...$otherTypeTypes);
    }
    private function resolveIntersectionTypeNode(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode $typeNode, \_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $types = $this->resolveMultiple($typeNode->types, $nameScope);
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::intersect(...$types);
    }
    private function resolveArrayTypeNode(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode $typeNode, \_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $itemType = $this->resolve($typeNode->type, $nameScope);
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), $itemType);
    }
    private function resolveGenericTypeNode(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode $typeNode, \_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $mainTypeName = \strtolower($typeNode->type->name);
        $genericTypes = $this->resolveMultiple($typeNode->genericTypes, $nameScope);
        if ($mainTypeName === 'array' || $mainTypeName === 'non-empty-array') {
            if (\count($genericTypes) === 1) {
                // array<ValueType>
                $arrayType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(\true), $genericTypes[0]);
            } elseif (\count($genericTypes) === 2) {
                // array<KeyType, ValueType>
                $arrayType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType($genericTypes[0], $genericTypes[1]);
            } else {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
            }
            if ($mainTypeName === 'non-empty-array') {
                return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::intersect($arrayType, new \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\NonEmptyArrayType());
            }
            return $arrayType;
        } elseif ($mainTypeName === 'list' || $mainTypeName === 'non-empty-list') {
            if (\count($genericTypes) === 1) {
                // list<ValueType>
                $listType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), $genericTypes[0]);
                if ($mainTypeName === 'non-empty-list') {
                    return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::intersect($listType, new \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\NonEmptyArrayType());
                }
                return $listType;
            }
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
        } elseif ($mainTypeName === 'iterable') {
            if (\count($genericTypes) === 1) {
                // iterable<ValueType>
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(\true), $genericTypes[0]);
            }
            if (\count($genericTypes) === 2) {
                // iterable<KeyType, ValueType>
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType($genericTypes[0], $genericTypes[1]);
            }
        } elseif ($mainTypeName === 'class-string') {
            if (\count($genericTypes) === 1) {
                $genericType = $genericTypes[0];
                if ((new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType())->isSuperTypeOf($genericType)->yes() || $genericType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
                    return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericClassStringType($genericType);
                }
            }
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
        }
        $mainType = $this->resolveIdentifierTypeNode($typeNode->type, $nameScope);
        if ($mainType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            if (!$this->getReflectionProvider()->hasClass($mainType->getClassName())) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), $genericTypes);
            }
            $classReflection = $this->getReflectionProvider()->getClass($mainType->getClassName());
            if ($classReflection->isGeneric()) {
                if (\in_array($mainType->getClassName(), [\Traversable::class, \IteratorAggregate::class, \Iterator::class], \true)) {
                    if (\count($genericTypes) === 1) {
                        return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), [new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(\true), $genericTypes[0]]);
                    }
                    if (\count($genericTypes) === 2) {
                        return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), [$genericTypes[0], $genericTypes[1]]);
                    }
                }
                if ($mainType->getClassName() === \Generator::class) {
                    if (\count($genericTypes) === 1) {
                        $mixed = new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(\true);
                        return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), [$mixed, $genericTypes[0], $mixed, $mixed]);
                    }
                    if (\count($genericTypes) === 2) {
                        $mixed = new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(\true);
                        return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), [$genericTypes[0], $genericTypes[1], $mixed, $mixed]);
                    }
                }
                if (!$mainType->isIterable()->yes()) {
                    return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), $genericTypes);
                }
                if (\count($genericTypes) !== 1 || $classReflection->getTemplateTypeMap()->count() === 1) {
                    return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), $genericTypes);
                }
            }
        }
        if ($mainType->isIterable()->yes()) {
            if (\count($genericTypes) === 1) {
                // Foo<ValueType>
                return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::intersect($mainType, new \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(\true), $genericTypes[0]));
            }
            if (\count($genericTypes) === 2) {
                // Foo<KeyType, ValueType>
                return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::intersect($mainType, new \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType($genericTypes[0], $genericTypes[1]));
            }
        }
        if ($mainType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), $genericTypes);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
    }
    private function resolveCallableTypeNode(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\CallableTypeNode $typeNode, \_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $mainType = $this->resolve($typeNode->identifier, $nameScope);
        $isVariadic = \false;
        $parameters = \array_map(function (\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\CallableTypeParameterNode $parameterNode) use($nameScope, &$isVariadic) : NativeParameterReflection {
            $isVariadic = $isVariadic || $parameterNode->isVariadic;
            $parameterName = $parameterNode->parameterName;
            if (\strpos($parameterName, '$') === 0) {
                $parameterName = \substr($parameterName, 1);
            }
            return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Native\NativeParameterReflection($parameterName, $parameterNode->isOptional || $parameterNode->isVariadic, $this->resolve($parameterNode->type, $nameScope), $parameterNode->isReference ? \_PhpScoperb75b35f52b74\PHPStan\Reflection\PassedByReference::createCreatesNewVariable() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\PassedByReference::createNo(), $parameterNode->isVariadic, null);
        }, $typeNode->parameters);
        $returnType = $this->resolve($typeNode->returnType, $nameScope);
        if ($mainType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\CallableType) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\CallableType($parameters, $returnType, $isVariadic);
        } elseif ($mainType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType && $mainType->getClassName() === \Closure::class) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ClosureType($parameters, $returnType, $isVariadic);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
    }
    private function resolveArrayShapeNode(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode $typeNode, \_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $builder = \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
        foreach ($typeNode->items as $itemNode) {
            $offsetType = null;
            if ($itemNode->keyName instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode) {
                $offsetType = new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType((int) $itemNode->keyName->value);
            } elseif ($itemNode->keyName instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
                $offsetType = new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType($itemNode->keyName->name);
            } elseif ($itemNode->keyName instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode) {
                $offsetType = new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType($itemNode->keyName->value);
            } elseif ($itemNode->keyName !== null) {
                throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException('Unsupported key node type: ' . \get_class($itemNode->keyName));
            }
            $builder->setOffsetValueType($offsetType, $this->resolve($itemNode->valueType, $nameScope), $itemNode->optional);
        }
        return $builder->getArray();
    }
    private function resolveConstTypeNode(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ConstTypeNode $typeNode, \_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $constExpr = $typeNode->constExpr;
        if ($constExpr instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
            // we prefer array shapes
        }
        if ($constExpr instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode || $constExpr instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode || $constExpr instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
            // we prefer IdentifierTypeNode
        }
        if ($constExpr instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode) {
            if ($constExpr->className === '') {
                throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
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
                                return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
                            }
                            $className = $classReflection->getParentClass()->getName();
                        }
                }
            }
            if (!isset($className)) {
                $className = $nameScope->resolveStringName($constExpr->className);
            }
            if (!$this->getReflectionProvider()->hasClass($className)) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
            }
            $classReflection = $this->getReflectionProvider()->getClass($className);
            $constantName = $constExpr->name;
            if (\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::endsWith($constantName, '*')) {
                $constantNameStartsWith = \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::substring($constantName, 0, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::length($constantName) - 1);
                $constantTypes = [];
                foreach ($classReflection->getNativeReflection()->getConstants() as $classConstantName => $constantValue) {
                    if (!\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::startsWith($classConstantName, $constantNameStartsWith)) {
                        continue;
                    }
                    $constantTypes[] = \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantTypeHelper::getTypeFromValue($constantValue);
                }
                if (\count($constantTypes) === 0) {
                    return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
                }
                return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...$constantTypes);
            }
            if (!$classReflection->hasConstant($constantName)) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
            }
            return $classReflection->getConstant($constantName)->getValueType();
        }
        if ($constExpr instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantTypeHelper::getTypeFromValue((float) $constExpr->value);
        }
        if ($constExpr instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantTypeHelper::getTypeFromValue((int) $constExpr->value);
        }
        if ($constExpr instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantTypeHelper::getTypeFromValue($constExpr->value);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
    }
    /**
     * @param TypeNode[] $typeNodes
     * @param NameScope $nameScope
     * @return Type[]
     */
    public function resolveMultiple(array $typeNodes, \_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope $nameScope) : array
    {
        $types = [];
        foreach ($typeNodes as $typeNode) {
            $types[] = $this->resolve($typeNode, $nameScope);
        }
        return $types;
    }
    private function getReflectionProvider() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider
    {
        return $this->container->getByType(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider::class);
    }
}
