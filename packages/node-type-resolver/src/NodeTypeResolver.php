<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Property;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\Accessory\NonEmptyArrayType;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\FloatType;
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
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeCorrector\GenericClassStringTypeCorrector;
use Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer;
use Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
use Rector\StaticTypeMapper\TypeFactory\UnionTypeFactory;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
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
     * @var TypeUnwrapper
     */
    private $typeUnwrapper;
    /**
     * @var ClassAnalyzer
     */
    private $classAnalyzer;
    /**
     * @var GenericClassStringTypeCorrector
     */
    private $genericClassStringTypeCorrector;
    /**
     * @var UnionTypeFactory
     */
    private $unionTypeFactory;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @param NodeTypeResolverInterface[] $nodeTypeResolvers
     */
    public function __construct(\Rector\TypeDeclaration\PHPStan\Type\ObjectTypeSpecifier $objectTypeSpecifier, \Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper, \Rector\Core\NodeAnalyzer\ClassAnalyzer $classAnalyzer, \Rector\NodeTypeResolver\NodeTypeCorrector\GenericClassStringTypeCorrector $genericClassStringTypeCorrector, \Rector\StaticTypeMapper\TypeFactory\UnionTypeFactory $unionTypeFactory, \PHPStan\Reflection\ReflectionProvider $reflectionProvider, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, array $nodeTypeResolvers)
    {
        foreach ($nodeTypeResolvers as $nodeTypeResolver) {
            $this->addNodeTypeResolver($nodeTypeResolver);
        }
        $this->objectTypeSpecifier = $objectTypeSpecifier;
        $this->typeUnwrapper = $typeUnwrapper;
        $this->classAnalyzer = $classAnalyzer;
        $this->genericClassStringTypeCorrector = $genericClassStringTypeCorrector;
        $this->unionTypeFactory = $unionTypeFactory;
        $this->reflectionProvider = $reflectionProvider;
        $this->nodeNameResolver = $nodeNameResolver;
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
        if ($requiredObjectType->isSuperTypeOf($resolvedType)->yes()) {
            return \true;
        }
        if ($resolvedType->equals($requiredObjectType)) {
            return \true;
        }
        return $this->isMatchingUnionType($resolvedType, $requiredObjectType);
    }
    public function resolve(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        $type = $this->resolveByNodeTypeResolvers($node);
        if ($type !== null) {
            return $type;
        }
        $nodeScope = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$nodeScope instanceof \PHPStan\Analyser\Scope) {
            return new \PHPStan\Type\MixedType();
        }
        if (!$node instanceof \PhpParser\Node\Expr) {
            return new \PHPStan\Type\MixedType();
        }
        // skip anonymous classes, ref https://github.com/rectorphp/rector/issues/1574
        if ($node instanceof \PhpParser\Node\Expr\New_) {
            $isAnonymousClass = $this->classAnalyzer->isAnonymousClass($node->class);
            if ($isAnonymousClass) {
                return new \PHPStan\Type\ObjectWithoutClassType();
            }
        }
        $type = $nodeScope->getType($node);
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
    /**
     * @deprecated
     * Use @see NodeTypeResolver::resolve() instead
     */
    public function getStaticType(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        if ($node instanceof \PhpParser\Node\Param) {
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
        if ($node instanceof \PhpParser\Node\Expr\New_) {
            $isAnonymousClass = $this->classAnalyzer->isAnonymousClass($node->class);
            if ($isAnonymousClass) {
                return $this->resolveAnonymousClassType($node);
            }
        }
        $staticType = $scope->getType($node);
        if (!$staticType instanceof \PHPStan\Type\ObjectType) {
            return $staticType;
        }
        return $this->objectTypeSpecifier->narrowToFullyQualifiedOrAliasedObjectType($node, $staticType);
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
    public function isObjectTypeOrNullableObjectType(\PhpParser\Node $node, \PHPStan\Type\ObjectType $desiredObjectType) : bool
    {
        if ($node instanceof \PhpParser\Node\Param && $node->type instanceof \PhpParser\Node\NullableType) {
            /** @var Name|Identifier $node */
            $node = $node->type->type;
        }
        if ($node instanceof \PhpParser\Node\Param && !$node->type instanceof \PhpParser\Node\Name) {
            return \false;
        }
        if ($this->isObjectType($node, $desiredObjectType)) {
            return \true;
        }
        $nodeType = $this->getStaticType($node);
        if (!$nodeType instanceof \PHPStan\Type\UnionType) {
            return \false;
        }
        $unwrappedNodeType = $this->typeUnwrapper->unwrapNullableType($nodeType);
        if (!$unwrappedNodeType instanceof \PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        return \is_a($unwrappedNodeType->getClassName(), $desiredObjectType->getClassName(), \true);
    }
    public function isNullableObjectType(\PhpParser\Node $node) : bool
    {
        return $this->isNullableTypeOfSpecificType($node, \PHPStan\Type\ObjectType::class);
    }
    public function isNullableArrayType(\PhpParser\Node $node) : bool
    {
        return $this->isNullableTypeOfSpecificType($node, \PHPStan\Type\ArrayType::class);
    }
    public function isNullableTypeOfSpecificType(\PhpParser\Node $node, string $desiredType) : bool
    {
        $nodeType = $this->resolve($node);
        if (!$nodeType instanceof \PHPStan\Type\UnionType) {
            return \false;
        }
        if ($nodeType->isSuperTypeOf(new \PHPStan\Type\NullType())->no()) {
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
    public function resolveObjectTypeToCompare(\PhpParser\Node $node) : ?\PHPStan\Type\ObjectType
    {
        if ($node instanceof \PhpParser\Node\Expr\StaticCall) {
            return $this->resolveStaticCallClassNameObjectTypeToCompare($node);
        }
        if ($node instanceof \PhpParser\Node\Stmt) {
            $classLike = $node->getAttribute(\PhpParser\Node\Stmt\ClassLike::class);
            if ($classLike === null) {
                return null;
            }
            $className = $this->nodeNameResolver->getName($classLike);
            if ($className === null) {
                return null;
            }
            if (!$this->reflectionProvider->hasClass($className)) {
                return null;
            }
            $classReflection = $this->reflectionProvider->getClass($className);
            if ($classReflection instanceof \PHPStan\Reflection\ClassReflection) {
                return new \PHPStan\Type\ObjectType($classReflection->getName(), null, $classReflection);
            }
        }
        $callerType = $this->resolve($node);
        if ($callerType instanceof \PHPStan\Type\ThisType) {
            $callerType = $callerType->getStaticObjectType();
        }
        if (!$callerType instanceof \PHPStan\Type\ObjectType) {
            return null;
        }
        return $callerType;
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
    /**
     * @deprecated
     */
    private function isMatchingUnionType(\PHPStan\Type\Type $resolvedType, \PHPStan\Type\ObjectType $requiredObjectType) : bool
    {
        if (!$resolvedType instanceof \PHPStan\Type\UnionType) {
            return \false;
        }
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
    private function resolveAnonymousClassType(\PhpParser\Node\Expr\New_ $new) : \PHPStan\Type\ObjectWithoutClassType
    {
        if (!$new->class instanceof \PhpParser\Node\Stmt\Class_) {
            return new \PHPStan\Type\ObjectWithoutClassType();
        }
        $types = [];
        /** @var Class_ $class */
        $class = $new->class;
        if ($class->extends !== null) {
            $parentClass = (string) $class->extends;
            $types[] = new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($parentClass);
        }
        foreach ($class->implements as $implement) {
            $parentClass = (string) $implement;
            $types[] = new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($parentClass);
        }
        if (\count($types) > 1) {
            $unionType = $this->unionTypeFactory->createUnionObjectType($types);
            return new \PHPStan\Type\ObjectWithoutClassType($unionType);
        }
        if (\count($types) === 1) {
            return new \PHPStan\Type\ObjectWithoutClassType($types[0]);
        }
        return new \PHPStan\Type\ObjectWithoutClassType();
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
    private function resolveStaticCallClassNameObjectTypeToCompare(\PhpParser\Node\Expr\StaticCall $staticCall) : ?\PHPStan\Type\ObjectType
    {
        $className = $this->nodeNameResolver->getName($staticCall->class);
        if ($className === 'parent') {
            /** @var Scope $scope */
            $scope = $staticCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
            $classReflection = $scope->getClassReflection();
            if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            $className = $classReflection->getName();
        }
        if ($className === null) {
            return null;
        }
        if (!$this->reflectionProvider->hasClass($className)) {
            return null;
        }
        $classReflection = $this->reflectionProvider->getClass($className);
        return new \PHPStan\Type\ObjectType($classReflection->getName(), null, $classReflection);
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
        if ($classReflection instanceof \PHPStan\Reflection\ClassReflection) {
            foreach ($classReflection->getAncestors() as $ancestorClassReflection) {
                if ($ancestorClassReflection->hasTraitUse($requiredObjectType->getClassName())) {
                    return \true;
                }
            }
        }
        return $classReflection->isSubclassOf($requiredObjectType->getClassName());
    }
}
