<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\TypeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_;
use _PhpScopere8e811afab72\PHPStan\Type\Accessory\HasOffsetType;
use _PhpScopere8e811afab72\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\IntersectionType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\ThisType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeCorrector\PregMatchTypeCorrector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
final class ArrayTypeAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var PregMatchTypeCorrector
     */
    private $pregMatchTypeCorrector;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeCorrector\PregMatchTypeCorrector $pregMatchTypeCorrector)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->pregMatchTypeCorrector = $pregMatchTypeCorrector;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isArrayType(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        $nodeStaticType = $this->nodeTypeResolver->resolve($node);
        $nodeStaticType = $this->pregMatchTypeCorrector->correct($node, $nodeStaticType);
        if ($this->isIntersectionArrayType($nodeStaticType)) {
            return \true;
        }
        // PHPStan false positive, when variable has type[] docblock, but default array is missing
        if (($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch) && !$this->isPropertyFetchWithArrayDefault($node)) {
            return \false;
        }
        if ($nodeStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            if ($nodeStaticType->isExplicitMixed()) {
                return \false;
            }
            if ($this->isPropertyFetchWithArrayDefault($node)) {
                return \true;
            }
        }
        return $nodeStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType;
    }
    private function isIntersectionArrayType(\_PhpScopere8e811afab72\PHPStan\Type\Type $nodeType) : bool
    {
        if (!$nodeType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
            return \false;
        }
        foreach ($nodeType->getTypes() as $intersectionNodeType) {
            if ($intersectionNodeType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType || $intersectionNodeType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Accessory\HasOffsetType || $intersectionNodeType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Accessory\NonEmptyArrayType) {
                continue;
            }
            return \false;
        }
        return \true;
    }
    /**
     * phpstan bug workaround - https://phpstan.org/r/0443f283-244c-42b8-8373-85e7deb3504c
     */
    private function isPropertyFetchWithArrayDefault(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch && !$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch) {
            return \false;
        }
        /** @var Class_|Trait_|Interface_|null $classLike */
        $classLike = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_ || $classLike === null) {
            return \false;
        }
        $propertyName = $this->nodeNameResolver->getName($node->name);
        if ($propertyName === null) {
            return \false;
        }
        $property = $classLike->getProperty($propertyName);
        if ($property !== null) {
            $propertyProperty = $property->props[0];
            return $propertyProperty->default instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
        }
        // also possible 3rd party vendor
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            $propertyOwnerStaticType = $this->nodeTypeResolver->resolve($node->var);
        } else {
            $propertyOwnerStaticType = $this->nodeTypeResolver->resolve($node->class);
        }
        if ($propertyOwnerStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ThisType) {
            return \false;
        }
        return $propertyOwnerStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
    }
}
