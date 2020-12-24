<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\TypeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Interface_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Trait_;
use _PhpScoperb75b35f52b74\PHPStan\Type\Accessory\HasOffsetType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ThisType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeCorrector\PregMatchTypeCorrector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeCorrector\PregMatchTypeCorrector $pregMatchTypeCorrector)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->pregMatchTypeCorrector = $pregMatchTypeCorrector;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isArrayType(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        $nodeStaticType = $this->nodeTypeResolver->resolve($node);
        $nodeStaticType = $this->pregMatchTypeCorrector->correct($node, $nodeStaticType);
        if ($this->isIntersectionArrayType($nodeStaticType)) {
            return \true;
        }
        // PHPStan false positive, when variable has type[] docblock, but default array is missing
        if (($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch) && !$this->isPropertyFetchWithArrayDefault($node)) {
            return \false;
        }
        if ($nodeStaticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            if ($nodeStaticType->isExplicitMixed()) {
                return \false;
            }
            if ($this->isPropertyFetchWithArrayDefault($node)) {
                return \true;
            }
        }
        return $nodeStaticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
    }
    private function isIntersectionArrayType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $nodeType) : bool
    {
        if (!$nodeType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType) {
            return \false;
        }
        foreach ($nodeType->getTypes() as $intersectionNodeType) {
            if ($intersectionNodeType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType || $intersectionNodeType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\HasOffsetType || $intersectionNodeType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\NonEmptyArrayType) {
                continue;
            }
            return \false;
        }
        return \true;
    }
    /**
     * phpstan bug workaround - https://phpstan.org/r/0443f283-244c-42b8-8373-85e7deb3504c
     */
    private function isPropertyFetchWithArrayDefault(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch) {
            return \false;
        }
        /** @var Class_|Trait_|Interface_|null $classLike */
        $classLike = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Interface_ || $classLike === null) {
            return \false;
        }
        $propertyName = $this->nodeNameResolver->getName($node->name);
        if ($propertyName === null) {
            return \false;
        }
        $property = $classLike->getProperty($propertyName);
        if ($property !== null) {
            $propertyProperty = $property->props[0];
            return $propertyProperty->default instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
        }
        // also possible 3rd party vendor
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
            $propertyOwnerStaticType = $this->nodeTypeResolver->resolve($node->var);
        } else {
            $propertyOwnerStaticType = $this->nodeTypeResolver->resolve($node->class);
        }
        if ($propertyOwnerStaticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ThisType) {
            return \false;
        }
        return $propertyOwnerStaticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
    }
}
