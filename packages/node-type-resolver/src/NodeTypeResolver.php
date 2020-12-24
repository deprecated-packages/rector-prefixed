<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\FloatType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\IntersectionType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\NodeAnalyzer\ClassNodeAnalyzer;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeCorrector\ParentClassLikeTypeCorrector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\PHPStan\Type\ObjectTypeSpecifier;
final class NodeTypeResolver
{
    /**
     * @var array<class-string, NodeTypeResolverInterface>
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
     * @var ParentClassLikeTypeCorrector
     */
    private $parentClassLikeTypeCorrector;
    /**
     * @var TypeUnwrapper
     */
    private $typeUnwrapper;
    /**
     * @var ClassNodeAnalyzer
     */
    private $classNodeAnalyzer;
    /**
     * @param NodeTypeResolverInterface[] $nodeTypeResolvers
     */
    public function __construct(\_PhpScopere8e811afab72\Rector\TypeDeclaration\PHPStan\Type\ObjectTypeSpecifier $objectTypeSpecifier, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeCorrector\ParentClassLikeTypeCorrector $parentClassLikeTypeCorrector, \_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper, \_PhpScopere8e811afab72\Rector\Core\NodeAnalyzer\ClassNodeAnalyzer $classNodeAnalyzer, array $nodeTypeResolvers)
    {
        foreach ($nodeTypeResolvers as $nodeTypeResolver) {
            $this->addNodeTypeResolver($nodeTypeResolver);
        }
        $this->objectTypeSpecifier = $objectTypeSpecifier;
        $this->parentClassLikeTypeCorrector = $parentClassLikeTypeCorrector;
        $this->typeUnwrapper = $typeUnwrapper;
        $this->classNodeAnalyzer = $classNodeAnalyzer;
    }
    /**
     * Prevents circular dependency
     * @required
     */
    public function autowireNodeTypeResolver(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer $arrayTypeAnalyzer) : void
    {
        $this->arrayTypeAnalyzer = $arrayTypeAnalyzer;
    }
    /**
     * @param ObjectType|string|mixed $requiredType
     */
    public function isObjectType(\_PhpScopere8e811afab72\PhpParser\Node $node, $requiredType) : bool
    {
        $this->ensureRequiredTypeIsStringOrObjectType($requiredType, __METHOD__);
        if (\is_string($requiredType) && \_PhpScopere8e811afab72\Nette\Utils\Strings::contains($requiredType, '*')) {
            return $this->isFnMatch($node, $requiredType);
        }
        $resolvedType = $this->resolve($node);
        if ($resolvedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return \false;
        }
        // this should also work with ObjectType and UnionType with ObjectType
        // use PHPStan types here
        if (\is_string($requiredType)) {
            $requiredType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($requiredType);
        }
        if ($resolvedType->equals($requiredType)) {
            return \true;
        }
        return $this->isMatchingUnionType($requiredType, $resolvedType);
    }
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $type = $this->resolveFirstType($node);
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return $type;
        }
        return $this->parentClassLikeTypeCorrector->correct($type);
    }
    /**
     * e.g. string|null, ObjectNull|null
     */
    public function isNullableType(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        $nodeType = $this->resolve($node);
        if (!$nodeType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return \false;
        }
        return $nodeType->isSuperTypeOf(new \_PhpScopere8e811afab72\PHPStan\Type\NullType())->yes();
    }
    /**
     * @deprecated
     * Use @see NodeTypeResolver::resolve() instead
     */
    public function getStaticType(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($this->isArrayExpr($node)) {
            /** @var Expr $node */
            return $this->resolveArrayType($node);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Arg) {
            $node = $node->value;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Param || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar) {
            return $this->resolve($node);
        }
        /** @var Scope|null $nodeScope */
        $nodeScope = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr || $nodeScope === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_ && $this->classNodeAnalyzer->isAnonymousClass($node->class)) {
            return $this->resolveAnonymousClassType($node);
        }
        $staticType = $nodeScope->getType($node);
        if (!$staticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
            return $staticType;
        }
        return $this->objectTypeSpecifier->narrowToFullyQualifiedOrAliasedObjectType($node, $staticType);
    }
    public function isNumberType(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->isStaticType($node, \_PhpScopere8e811afab72\PHPStan\Type\IntegerType::class) || $this->isStaticType($node, \_PhpScopere8e811afab72\PHPStan\Type\FloatType::class);
    }
    public function isStaticType(\_PhpScopere8e811afab72\PhpParser\Node $node, string $staticTypeClass) : bool
    {
        if (!\is_a($staticTypeClass, \_PhpScopere8e811afab72\PHPStan\Type\Type::class, \true)) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException(\sprintf('"%s" in "%s()" must be type of "%s"', $staticTypeClass, __METHOD__, \_PhpScopere8e811afab72\PHPStan\Type\Type::class));
        }
        return \is_a($this->resolve($node), $staticTypeClass);
    }
    /**
     * @param ObjectType|string $desiredType
     */
    public function isObjectTypeOrNullableObjectType(\_PhpScopere8e811afab72\PhpParser\Node $node, $desiredType) : bool
    {
        if ($this->isObjectType($node, $desiredType)) {
            return \true;
        }
        $nodeType = $this->getStaticType($node);
        if (!$nodeType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return \false;
        }
        $unwrappedNodeType = $this->typeUnwrapper->unwrapNullableType($nodeType);
        if (!$unwrappedNodeType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        $desiredTypeString = $desiredType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType ? $desiredType->getClassName() : $desiredType;
        return \is_a($unwrappedNodeType->getClassName(), $desiredTypeString, \true);
    }
    public function isNullableObjectType(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->isNullableTypeOfSpecificType($node, \_PhpScopere8e811afab72\PHPStan\Type\ObjectType::class);
    }
    public function isNullableArrayType(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->isNullableTypeOfSpecificType($node, \_PhpScopere8e811afab72\PHPStan\Type\ArrayType::class);
    }
    public function isNullableTypeOfSpecificType(\_PhpScopere8e811afab72\PhpParser\Node $node, string $desiredType) : bool
    {
        $nodeType = $this->resolve($node);
        if (!$nodeType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return \false;
        }
        if ($nodeType->isSuperTypeOf(new \_PhpScopere8e811afab72\PHPStan\Type\NullType())->no()) {
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
    public function isPropertyBoolean(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : bool
    {
        if ($this->isStaticType($property, \_PhpScopere8e811afab72\PHPStan\Type\BooleanType::class)) {
            return \true;
        }
        $defaultNodeValue = $property->props[0]->default;
        if ($defaultNodeValue === null) {
            return \false;
        }
        return $this->isStaticType($defaultNodeValue, \_PhpScopere8e811afab72\PHPStan\Type\BooleanType::class);
    }
    private function addNodeTypeResolver(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface $nodeTypeResolver) : void
    {
        foreach ($nodeTypeResolver->getNodeClasses() as $nodeClass) {
            $this->nodeTypeResolvers[$nodeClass] = $nodeTypeResolver;
        }
    }
    /**
     * @param ObjectType|string|mixed $requiredType
     */
    private function ensureRequiredTypeIsStringOrObjectType($requiredType, string $location) : void
    {
        if (\is_string($requiredType)) {
            return;
        }
        if ($requiredType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
            return;
        }
        $reportedType = \is_object($requiredType) ? \get_class($requiredType) : $requiredType;
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException(\sprintf('Value passed to "%s()" must be string or "%s". "%s" given', $location, \_PhpScopere8e811afab72\PHPStan\Type\ObjectType::class, $reportedType));
    }
    private function isFnMatch(\_PhpScopere8e811afab72\PhpParser\Node $node, string $requiredType) : bool
    {
        $objectType = $this->resolve($node);
        $classNames = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getDirectClassNames($objectType);
        foreach ($classNames as $className) {
            if (!\fnmatch($requiredType, $className, \FNM_NOESCAPE)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    private function isMatchingUnionType(\_PhpScopere8e811afab72\PHPStan\Type\Type $requiredType, \_PhpScopere8e811afab72\PHPStan\Type\Type $resolvedType) : bool
    {
        if (!$resolvedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return \false;
        }
        foreach ($resolvedType->getTypes() as $unionedType) {
            if (!$unionedType->equals($requiredType)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    private function resolveFirstType(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $type = $this->resolveByNodeTypeResolvers($node);
        if ($type !== null) {
            return $type;
        }
        /** @var Scope|null $nodeScope */
        $nodeScope = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($nodeScope === null || !$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        // skip anonymous classes, ref https://github.com/rectorphp/rector/issues/1574
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_ && $this->classNodeAnalyzer->isAnonymousClass($node->class)) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType();
        }
        $type = $nodeScope->getType($node);
        // hot fix for phpstan not resolving chain method calls
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall && $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return $this->resolveFirstType($node->var);
        }
        return $type;
    }
    private function isArrayExpr(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr) {
            return \false;
        }
        return $this->arrayTypeAnalyzer->isArrayType($node);
    }
    private function resolveArrayType(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        /** @var Scope|null $scope */
        $scope = $expr->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope instanceof \_PhpScopere8e811afab72\PHPStan\Analyser\Scope) {
            $arrayType = $scope->getType($expr);
            if ($arrayType !== null) {
                return $this->removeNonEmptyArrayFromIntersectionWithArrayType($arrayType);
            }
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
    }
    private function resolveAnonymousClassType(\_PhpScopere8e811afab72\PhpParser\Node\Expr\New_ $new) : \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType
    {
        if (!$new->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType();
        }
        $types = [];
        /** @var Class_ $class */
        $class = $new->class;
        if ($class->extends !== null) {
            $parentClass = (string) $class->extends;
            $types[] = new \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType($parentClass);
        }
        foreach ((array) $class->implements as $implement) {
            $parentClass = (string) $implement;
            $types[] = new \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType($parentClass);
        }
        if (\count($types) > 1) {
            $unionType = \_PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType($types);
            return new \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType($unionType);
        }
        if (\count($types) === 1) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType($types[0]);
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType();
    }
    private function resolveByNodeTypeResolvers(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        foreach ($this->nodeTypeResolvers as $nodeClass => $nodeTypeResolver) {
            if (!\is_a($node, $nodeClass)) {
                continue;
            }
            return $nodeTypeResolver->resolve($node);
        }
        return null;
    }
    private function removeNonEmptyArrayFromIntersectionWithArrayType(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
            return $type;
        }
        if (\count($type->getTypes()) !== 2) {
            return $type;
        }
        if (!$type->isSubTypeOf(new \_PhpScopere8e811afab72\PHPStan\Type\Accessory\NonEmptyArrayType())->yes()) {
            return $type;
        }
        $otherType = null;
        foreach ($type->getTypes() as $intersectionedType) {
            if ($intersectionedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Accessory\NonEmptyArrayType) {
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
}
