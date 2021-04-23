<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\Accessory\NonEmptyArrayType;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\FloatType;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\ThisType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\UnionType;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\NodeAnalyzer\ClassAnalyzer;
use Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeCorrector\GenericClassStringTypeCorrector;
use Rector\NodeTypeResolver\NodeTypeCorrector\HasOffsetTypeCorrector;
use Rector\NodeTypeResolver\NodeTypeResolver\IdentifierTypeResolver;
use Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer;
use Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType;
use Rector\TypeDeclaration\PHPStan\Type\ObjectTypeSpecifier;
final class NodeTypeResolver
{
    /**
     * @var array<class-string<Node>, NodeTypeResolverInterface>
     */
    private $nodeTypeResolvers = [];
    /**
     * @var ObjectTypeSpecifier
     */
    private $objectTypeSpecifier;
    /**
     * @var ArrayTypeAnalyzer
     */
    private $arrayTypeAnalyzer;
    /**
     * @var ClassAnalyzer
     */
    private $classAnalyzer;
    /**
     * @var GenericClassStringTypeCorrector
     */
    private $genericClassStringTypeCorrector;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    /**
     * @var HasOffsetTypeCorrector
     */
    private $hasOffsetTypeCorrector;
    /**
     * @var IdentifierTypeResolver
     */
    private $identifierTypeResolver;
    /**
     * @param NodeTypeResolverInterface[] $nodeTypeResolvers
     */
    public function __construct(\Rector\TypeDeclaration\PHPStan\Type\ObjectTypeSpecifier $objectTypeSpecifier, \Rector\Core\NodeAnalyzer\ClassAnalyzer $classAnalyzer, \Rector\NodeTypeResolver\NodeTypeCorrector\GenericClassStringTypeCorrector $genericClassStringTypeCorrector, \PHPStan\Reflection\ReflectionProvider $reflectionProvider, \Rector\NodeTypeResolver\NodeTypeCorrector\HasOffsetTypeCorrector $hasOffsetTypeCorrector, \Rector\NodeTypeResolver\NodeTypeResolver\IdentifierTypeResolver $identifierTypeResolver, array $nodeTypeResolvers)
    {
        foreach ($nodeTypeResolvers as $nodeTypeResolver) {
            $this->addNodeTypeResolver($nodeTypeResolver);
        }
        $this->objectTypeSpecifier = $objectTypeSpecifier;
        $this->classAnalyzer = $classAnalyzer;
        $this->genericClassStringTypeCorrector = $genericClassStringTypeCorrector;
        $this->reflectionProvider = $reflectionProvider;
        $this->hasOffsetTypeCorrector = $hasOffsetTypeCorrector;
        $this->identifierTypeResolver = $identifierTypeResolver;
    }
    /**
     * Prevents circular dependency
     *
     * @required
     */
    public function autowireNodeTypeResolver(\Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer $arrayTypeAnalyzer) : void
    {
        $this->arrayTypeAnalyzer = $arrayTypeAnalyzer;
    }
    /**
     * @param ObjectType[] $requiredTypes
     */
    public function isObjectTypes(\PhpParser\Node $node, array $requiredTypes) : bool
    {
        foreach ($requiredTypes as $requiredType) {
            if ($this->isObjectType($node, $requiredType)) {
                return \true;
            }
        }
        return \false;
    }
    public function isObjectType(\PhpParser\Node $node, \PHPStan\Type\ObjectType $requiredObjectType) : bool
    {
        if ($node instanceof \PhpParser\Node\Expr\ClassConstFetch) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $resolvedType = $this->resolve($node);
        if ($resolvedType instanceof \PHPStan\Type\MixedType) {
            return \false;
        }
        if ($resolvedType instanceof \PHPStan\Type\ThisType) {
            $resolvedType = $resolvedType->getStaticObjectType();
        }
        if ($resolvedType instanceof \PHPStan\Type\ObjectType) {
            return $this->isObjectTypeOfObjectType($resolvedType, $requiredObjectType);
        }
        return $this->isMatchingUnionType($resolvedType, $requiredObjectType);
    }
    public function resolve(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        $type = $this->resolveByNodeTypeResolvers($node);
        if ($type !== null) {
            return $this->hasOffsetTypeCorrector->correct($type);
        }
        $scope = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            if ($node instanceof \PhpParser\Node\Expr\ConstFetch && $node->name instanceof \PhpParser\Node\Name) {
                $name = (string) $node->name;
                if (\strtolower($name) === 'null') {
                    return new \PHPStan\Type\NullType();
                }
            }
            return new \PHPStan\Type\MixedType();
        }
        if (!$node instanceof \PhpParser\Node\Expr) {
            // scalar type, e.g. from param type name
            if ($node instanceof \PhpParser\Node\Identifier) {
                return $this->identifierTypeResolver->resolve($node);
            }
            return new \PHPStan\Type\MixedType();
        }
        // skip anonymous classes, ref https://github.com/rectorphp/rector/issues/1574
        if ($node instanceof \PhpParser\Node\Expr\New_ && $this->classAnalyzer->isAnonymousClass($node->class)) {
            return new \PHPStan\Type\ObjectWithoutClassType();
        }
        $type = $scope->getType($node);
        // hot fix for phpstan not resolving chain method calls
        if (!$node instanceof \PhpParser\Node\Expr\MethodCall) {
            return $type;
        }
        if (!$type instanceof \PHPStan\Type\MixedType) {
            return $type;
        }
        return $this->resolve($node->var);
    }
    /**
     * e.g. string|null, ObjectNull|null
     */
    public function isNullableType(\PhpParser\Node $node) : bool
    {
        $nodeType = $this->resolve($node);
        return \PHPStan\Type\TypeCombinator::containsNull($nodeType);
    }
    public function getNativeType(\PhpParser\Node\Expr $expr) : \PHPStan\Type\Type
    {
        $scope = $expr->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            return new \PHPStan\Type\MixedType();
        }
        return $scope->getNativeType($expr);
    }
    public function getStaticType(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        if ($node instanceof \PhpParser\Node\Param) {
            return $this->resolve($node);
        }
        if ($node instanceof \PhpParser\Node\Expr\New_) {
            return $this->resolve($node);
        }
        if ($node instanceof \PhpParser\Node\Stmt\Return_) {
            return $this->resolve($node);
        }
        if (!$node instanceof \PhpParser\Node\Expr) {
            return new \PHPStan\Type\MixedType();
        }
        if ($this->arrayTypeAnalyzer->isArrayType($node)) {
            return $this->resolveArrayType($node);
        }
        if ($node instanceof \PhpParser\Node\Scalar) {
            return $this->resolve($node);
        }
        $scope = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            return new \PHPStan\Type\MixedType();
        }
        $staticType = $scope->getType($node);
        if ($staticType instanceof \PHPStan\Type\Generic\GenericObjectType) {
            return $staticType;
        }
        if ($staticType instanceof \PHPStan\Type\ObjectType) {
            return $this->objectTypeSpecifier->narrowToFullyQualifiedOrAliasedObjectType($node, $staticType);
        }
        return $staticType;
    }
    public function isNumberType(\PhpParser\Node $node) : bool
    {
        if ($this->isStaticType($node, \PHPStan\Type\IntegerType::class)) {
            return \true;
        }
        return $this->isStaticType($node, \PHPStan\Type\FloatType::class);
    }
    /**
     * @param class-string<Type> $staticTypeClass
     */
    public function isStaticType(\PhpParser\Node $node, string $staticTypeClass) : bool
    {
        if (!\is_a($staticTypeClass, \PHPStan\Type\Type::class, \true)) {
            throw new \Rector\Core\Exception\ShouldNotHappenException(\sprintf('"%s" in "%s()" must be type of "%s"', $staticTypeClass, __METHOD__, \PHPStan\Type\Type::class));
        }
        return \is_a($this->resolve($node), $staticTypeClass);
    }
    /**
     * @param class-string<Type> $desiredType
     */
    public function isNullableTypeOfSpecificType(\PhpParser\Node $node, string $desiredType) : bool
    {
        $nodeType = $this->resolve($node);
        if (!$nodeType instanceof \PHPStan\Type\UnionType) {
            return \false;
        }
        if (!\PHPStan\Type\TypeCombinator::containsNull($nodeType)) {
            return \false;
        }
        if (\count($nodeType->getTypes()) !== 2) {
            return \false;
        }
        foreach ($nodeType->getTypes() as $type) {
            if (\is_a($type, $desiredType, \true)) {
                return \true;
            }
        }
        return \false;
    }
    public function isPropertyBoolean(\PhpParser\Node\Stmt\Property $property) : bool
    {
        if ($this->isStaticType($property, \PHPStan\Type\BooleanType::class)) {
            return \true;
        }
        $defaultNodeValue = $property->props[0]->default;
        if (!$defaultNodeValue instanceof \PhpParser\Node\Expr) {
            return \false;
        }
        return $this->isStaticType($defaultNodeValue, \PHPStan\Type\BooleanType::class);
    }
    /**
     * @return class-string
     */
    public function getFullyQualifiedClassName(\PHPStan\Type\TypeWithClassName $typeWithClassName) : string
    {
        if ($typeWithClassName instanceof \Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType) {
            return $typeWithClassName->getFullyQualifiedName();
        }
        return $typeWithClassName->getClassName();
    }
    /**
     * @param Type[] $desiredTypes
     */
    public function isSameObjectTypes(\PHPStan\Type\ObjectType $objectType, array $desiredTypes) : bool
    {
        foreach ($desiredTypes as $desiredType) {
            $desiredTypeEquals = $desiredType->equals($objectType);
            if ($desiredTypeEquals) {
                return \true;
            }
        }
        return \false;
    }
    public function isMethodStaticCallOrClassMethodObjectType(\PhpParser\Node $node, \PHPStan\Type\ObjectType $objectType) : bool
    {
        if ($node instanceof \PhpParser\Node\Expr\MethodCall) {
            // method call is variable return
            return $this->isObjectType($node->var, $objectType);
        }
        if ($node instanceof \PhpParser\Node\Expr\StaticCall) {
            return $this->isObjectType($node->class, $objectType);
        }
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        return $this->isObjectType($classLike, $objectType);
    }
    public function resolveObjectTypeFromScope(\PHPStan\Analyser\Scope $scope) : ?\PHPStan\Type\ObjectType
    {
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
            return null;
        }
        $className = $classReflection->getName();
        if (!$this->reflectionProvider->hasClass($className)) {
            return null;
        }
        return new \PHPStan\Type\ObjectType($className, null, $classReflection);
    }
    private function addNodeTypeResolver(\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface $nodeTypeResolver) : void
    {
        foreach ($nodeTypeResolver->getNodeClasses() as $nodeClass) {
            $this->nodeTypeResolvers[$nodeClass] = $nodeTypeResolver;
        }
    }
    private function isMatchingUnionType(\PHPStan\Type\Type $resolvedType, \PHPStan\Type\ObjectType $requiredObjectType) : bool
    {
        $type = \PHPStan\Type\TypeCombinator::removeNull($resolvedType);
        // for falsy nullables
        $type = \PHPStan\Type\TypeCombinator::remove($type, new \PHPStan\Type\Constant\ConstantBooleanType(\false));
        if (!$type instanceof \PHPStan\Type\ObjectType) {
            return \false;
        }
        return $type->isInstanceOf($requiredObjectType->getClassName())->yes();
    }
    private function resolveArrayType(\PhpParser\Node\Expr $expr) : \PHPStan\Type\Type
    {
        /** @var Scope|null $scope */
        $scope = $expr->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope instanceof \PHPStan\Analyser\Scope) {
            $arrayType = $scope->getType($expr);
            $arrayType = $this->genericClassStringTypeCorrector->correct($arrayType);
            return $this->removeNonEmptyArrayFromIntersectionWithArrayType($arrayType);
        }
        return new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
    }
    private function resolveByNodeTypeResolvers(\PhpParser\Node $node) : ?\PHPStan\Type\Type
    {
        foreach ($this->nodeTypeResolvers as $nodeClass => $nodeTypeResolver) {
            if (!\is_a($node, $nodeClass)) {
                continue;
            }
            return $nodeTypeResolver->resolve($node);
        }
        return null;
    }
    private function removeNonEmptyArrayFromIntersectionWithArrayType(\PHPStan\Type\Type $type) : \PHPStan\Type\Type
    {
        if (!$type instanceof \PHPStan\Type\IntersectionType) {
            return $type;
        }
        if (\count($type->getTypes()) !== 2) {
            return $type;
        }
        if (!$type->isSubTypeOf(new \PHPStan\Type\Accessory\NonEmptyArrayType())->yes()) {
            return $type;
        }
        $otherType = null;
        foreach ($type->getTypes() as $intersectionedType) {
            if ($intersectionedType instanceof \PHPStan\Type\Accessory\NonEmptyArrayType) {
                continue;
            }
            $otherType = $intersectionedType;
            break;
        }
        if ($otherType === null) {
            return $type;
        }
        return $otherType;
    }
    private function isObjectTypeOfObjectType(\PHPStan\Type\ObjectType $resolvedObjectType, \PHPStan\Type\ObjectType $requiredObjectType) : bool
    {
        if ($resolvedObjectType->isInstanceOf($requiredObjectType->getClassName())->yes()) {
            return \true;
        }
        if ($resolvedObjectType->getClassName() === $requiredObjectType->getClassName()) {
            return \true;
        }
        if (!$this->reflectionProvider->hasClass($resolvedObjectType->getClassName())) {
            return \false;
        }
        $classReflection = $this->reflectionProvider->getClass($resolvedObjectType->getClassName());
        foreach ($classReflection->getAncestors() as $ancestorClassReflection) {
            if ($ancestorClassReflection->hasTraitUse($requiredObjectType->getClassName())) {
                return \true;
            }
        }
        return $classReflection->isSubclassOf($requiredObjectType->getClassName());
    }
}
