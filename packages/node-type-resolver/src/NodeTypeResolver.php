<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver;

use RectorPrefix20210130\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use PHPStan\Analyser\Scope;
use PHPStan\Type\Accessory\NonEmptyArrayType;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeUtils;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\UnionType;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\NodeAnalyzer\ClassNodeAnalyzer;
use Rector\Core\Util\StaticInstanceOf;
use Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeCorrector\ParentClassLikeTypeCorrector;
use Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer;
use Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
use Rector\StaticTypeMapper\TypeFactory\TypeFactoryStaticHelper;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
use Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType;
use Rector\TypeDeclaration\PHPStan\Type\ObjectTypeSpecifier;
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
    public function __construct(\Rector\TypeDeclaration\PHPStan\Type\ObjectTypeSpecifier $objectTypeSpecifier, \Rector\NodeTypeResolver\NodeTypeCorrector\ParentClassLikeTypeCorrector $parentClassLikeTypeCorrector, \Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper, \Rector\Core\NodeAnalyzer\ClassNodeAnalyzer $classNodeAnalyzer, array $nodeTypeResolvers)
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
    public function autowireNodeTypeResolver(\Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer $arrayTypeAnalyzer) : void
    {
        $this->arrayTypeAnalyzer = $arrayTypeAnalyzer;
    }
    /**
     * @param string[]|ObjectType[] $requiredTypes
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
    /**
     * @param ObjectType|string|mixed $requiredType
     */
    public function isObjectType(\PhpParser\Node $node, $requiredType) : bool
    {
        $this->ensureRequiredTypeIsStringOrObjectType($requiredType, __METHOD__);
        if (\is_string($requiredType) && \RectorPrefix20210130\Nette\Utils\Strings::contains($requiredType, '*')) {
            return $this->isFnMatch($node, $requiredType);
        }
        $resolvedType = $this->resolve($node);
        if ($resolvedType instanceof \PHPStan\Type\MixedType) {
            return \false;
        }
        // this should also work with ObjectType and UnionType with ObjectType
        // use PHPStan types here
        if (\is_string($requiredType)) {
            $requiredType = new \PHPStan\Type\ObjectType($requiredType);
        }
        if ($resolvedType->equals($requiredType)) {
            return \true;
        }
        return $this->isMatchingUnionType($requiredType, $resolvedType);
    }
    public function resolve(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        $type = $this->resolveFirstType($node);
        if (!$type instanceof \PHPStan\Type\TypeWithClassName) {
            return $type;
        }
        return $this->parentClassLikeTypeCorrector->correct($type);
    }
    /**
     * e.g. string|null, ObjectNull|null
     */
    public function isNullableType(\PhpParser\Node $node) : bool
    {
        $nodeType = $this->resolve($node);
        if (!$nodeType instanceof \PHPStan\Type\UnionType) {
            return \false;
        }
        return $nodeType->isSuperTypeOf(new \PHPStan\Type\NullType())->yes();
    }
    /**
     * @deprecated
     * Use @see NodeTypeResolver::resolve() instead
     */
    public function getStaticType(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        if ($this->isArrayExpr($node)) {
            /** @var Expr $node */
            return $this->resolveArrayType($node);
        }
        if ($node instanceof \PhpParser\Node\Arg) {
            $node = $node->value;
        }
        if (\Rector\Core\Util\StaticInstanceOf::isOneOf($node, [\PhpParser\Node\Param::class, \PhpParser\Node\Scalar::class])) {
            return $this->resolve($node);
        }
        $nodeScope = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$node instanceof \PhpParser\Node\Expr) {
            return new \PHPStan\Type\MixedType();
        }
        if (!$nodeScope instanceof \PHPStan\Analyser\Scope) {
            return new \PHPStan\Type\MixedType();
        }
        if ($node instanceof \PhpParser\Node\Expr\New_ && $this->classNodeAnalyzer->isAnonymousClass($node->class)) {
            return $this->resolveAnonymousClassType($node);
        }
        $staticType = $nodeScope->getType($node);
        if (!$staticType instanceof \PHPStan\Type\ObjectType) {
            return $staticType;
        }
        return $this->objectTypeSpecifier->narrowToFullyQualifiedOrAliasedObjectType($node, $staticType);
    }
    public function isNumberType(\PhpParser\Node $node) : bool
    {
        return $this->isStaticType($node, \PHPStan\Type\IntegerType::class) || $this->isStaticType($node, \PHPStan\Type\FloatType::class);
    }
    public function isStaticType(\PhpParser\Node $node, string $staticTypeClass) : bool
    {
        if (!\is_a($staticTypeClass, \PHPStan\Type\Type::class, \true)) {
            throw new \Rector\Core\Exception\ShouldNotHappenException(\sprintf('"%s" in "%s()" must be type of "%s"', $staticTypeClass, __METHOD__, \PHPStan\Type\Type::class));
        }
        return \is_a($this->resolve($node), $staticTypeClass);
    }
    /**
     * @param ObjectType|string $desiredType
     */
    public function isObjectTypeOrNullableObjectType(\PhpParser\Node $node, $desiredType) : bool
    {
        if ($this->isObjectType($node, $desiredType)) {
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
        $desiredTypeString = $desiredType instanceof \PHPStan\Type\ObjectType ? $desiredType->getClassName() : $desiredType;
        return \is_a($unwrappedNodeType->getClassName(), $desiredTypeString, \true);
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
    private function addNodeTypeResolver(\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface $nodeTypeResolver) : void
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
        if ($requiredType instanceof \PHPStan\Type\ObjectType) {
            return;
        }
        $reportedType = \is_object($requiredType) ? \get_class($requiredType) : $requiredType;
        throw new \Rector\Core\Exception\ShouldNotHappenException(\sprintf('Value passed to "%s()" must be string or "%s". "%s" given', $location, \PHPStan\Type\ObjectType::class, $reportedType));
    }
    private function isFnMatch(\PhpParser\Node $node, string $requiredType) : bool
    {
        $objectType = $this->resolve($node);
        $classNames = \PHPStan\Type\TypeUtils::getDirectClassNames($objectType);
        foreach ($classNames as $className) {
            if (!\fnmatch($requiredType, $className, \FNM_NOESCAPE)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    private function isMatchingUnionType(\PHPStan\Type\Type $requiredType, \PHPStan\Type\Type $resolvedType) : bool
    {
        if (!$resolvedType instanceof \PHPStan\Type\UnionType) {
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
    private function resolveFirstType(\PhpParser\Node $node) : \PHPStan\Type\Type
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
        if ($node instanceof \PhpParser\Node\Expr\New_ && $this->classNodeAnalyzer->isAnonymousClass($node->class)) {
            return new \PHPStan\Type\ObjectWithoutClassType();
        }
        $type = $nodeScope->getType($node);
        // hot fix for phpstan not resolving chain method calls
        if ($node instanceof \PhpParser\Node\Expr\MethodCall && $type instanceof \PHPStan\Type\MixedType) {
            return $this->resolveFirstType($node->var);
        }
        return $type;
    }
    private function isArrayExpr(\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr) {
            return \false;
        }
        return $this->arrayTypeAnalyzer->isArrayType($node);
    }
    private function resolveArrayType(\PhpParser\Node\Expr $expr) : \PHPStan\Type\Type
    {
        /** @var Scope|null $scope */
        $scope = $expr->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope instanceof \PHPStan\Analyser\Scope) {
            $arrayType = $scope->getType($expr);
            if ($arrayType !== null) {
                return $this->removeNonEmptyArrayFromIntersectionWithArrayType($arrayType);
            }
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
            $unionType = \Rector\StaticTypeMapper\TypeFactory\TypeFactoryStaticHelper::createUnionObjectType($types);
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
}
