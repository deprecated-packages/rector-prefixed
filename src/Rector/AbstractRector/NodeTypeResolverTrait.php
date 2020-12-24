<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\TypeAnalyzer\CountableTypeAnalyzer;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\TypeAnalyzer\StringTypeAnalyzer;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
/**
 * This could be part of @see AbstractRector, but decopuling to trait
 * makes clear what code has 1 purpose.
 */
trait NodeTypeResolverTrait
{
    /**
     * @var TypeUnwrapper
     */
    protected $typeUnwrapper;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var ArrayTypeAnalyzer
     */
    private $arrayTypeAnalyzer;
    /**
     * @var CountableTypeAnalyzer
     */
    private $countableTypeAnalyzer;
    /**
     * @var StringTypeAnalyzer
     */
    private $stringTypeAnalyzer;
    /**
     * @required
     */
    public function autowireNodeTypeResolverTrait(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer $arrayTypeAnalyzer, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\TypeAnalyzer\CountableTypeAnalyzer $countableTypeAnalyzer, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\TypeAnalyzer\StringTypeAnalyzer $stringTypeAnalyzer, \_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->arrayTypeAnalyzer = $arrayTypeAnalyzer;
        $this->countableTypeAnalyzer = $countableTypeAnalyzer;
        $this->stringTypeAnalyzer = $stringTypeAnalyzer;
        $this->typeUnwrapper = $typeUnwrapper;
    }
    public function isInObjectType(\_PhpScopere8e811afab72\PhpParser\Node $node, string $type) : bool
    {
        $objectType = $this->nodeTypeResolver->resolve($node);
        $desiredObjectType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($type);
        if ($objectType->isSuperTypeOf($desiredObjectType)->yes()) {
            return \true;
        }
        return $objectType->equals($desiredObjectType);
    }
    public function isPropertyBoolean(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : bool
    {
        return $this->nodeTypeResolver->isPropertyBoolean($property);
    }
    /**
     * @param ObjectType|string $type
     */
    protected function isObjectType(\_PhpScopere8e811afab72\PhpParser\Node $node, $type) : bool
    {
        return $this->nodeTypeResolver->isObjectType($node, $type);
    }
    /**
     * @param string[]|ObjectType[] $requiredTypes
     */
    protected function isObjectTypes(\_PhpScopere8e811afab72\PhpParser\Node $node, array $requiredTypes) : bool
    {
        foreach ($requiredTypes as $requiredType) {
            if ($this->isObjectType($node, $requiredType)) {
                return \true;
            }
        }
        return \false;
    }
    protected function isReturnOfObjectType(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_ $return, string $objectType) : bool
    {
        if ($return->expr === null) {
            return \false;
        }
        $returnType = $this->getStaticType($return->expr);
        if (!$returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        return \is_a($returnType->getClassName(), $objectType, \true);
    }
    /**
     * @param Type[] $desiredTypes
     */
    protected function isSameObjectTypes(\_PhpScopere8e811afab72\PHPStan\Type\ObjectType $objectType, array $desiredTypes) : bool
    {
        foreach ($desiredTypes as $abstractClassConstructorParamType) {
            if ($abstractClassConstructorParamType->equals($objectType)) {
                return \true;
            }
        }
        return \false;
    }
    protected function isStringOrUnionStringOnlyType(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->stringTypeAnalyzer->isStringOrUnionStringOnlyType($node);
    }
    protected function isNumberType(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->nodeTypeResolver->isNumberType($node);
    }
    protected function isStaticType(\_PhpScopere8e811afab72\PhpParser\Node $node, string $staticTypeClass) : bool
    {
        return $this->nodeTypeResolver->isStaticType($node, $staticTypeClass);
    }
    protected function getStaticType(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->nodeTypeResolver->getStaticType($node);
    }
    protected function isNullableType(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->nodeTypeResolver->isNullableType($node);
    }
    protected function isNullableObjectType(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->nodeTypeResolver->isNullableObjectType($node);
    }
    protected function isNullableArrayType(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->nodeTypeResolver->isNullableArrayType($node);
    }
    protected function isCountableType(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->countableTypeAnalyzer->isCountableType($node);
    }
    protected function isArrayType(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->arrayTypeAnalyzer->isArrayType($node);
    }
    protected function getObjectType(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->nodeTypeResolver->resolve($node);
    }
    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     */
    protected function isMethodStaticCallOrClassMethodObjectType(\_PhpScopere8e811afab72\PhpParser\Node $node, string $type) : bool
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            if ($node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
                return $this->isObjectType($node->var, $type);
            }
            // method call is variable return
            return $this->isObjectType($node->var, $type);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            return $this->isObjectType($node->class, $type);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            /** @var Class_|null $classLike */
            $classLike = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            if ($classLike === null) {
                return \false;
            }
            return $this->isObjectType($classLike, $type);
        }
        return \false;
    }
}
