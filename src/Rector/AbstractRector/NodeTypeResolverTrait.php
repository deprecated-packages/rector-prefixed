<?php

declare (strict_types=1);
namespace Rector\Core\Rector\AbstractRector;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer;
use Rector\NodeTypeResolver\TypeAnalyzer\CountableTypeAnalyzer;
use Rector\NodeTypeResolver\TypeAnalyzer\StringTypeAnalyzer;
use Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
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
    public function autowireNodeTypeResolverTrait(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer $arrayTypeAnalyzer, \Rector\NodeTypeResolver\TypeAnalyzer\CountableTypeAnalyzer $countableTypeAnalyzer, \Rector\NodeTypeResolver\TypeAnalyzer\StringTypeAnalyzer $stringTypeAnalyzer, \Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->arrayTypeAnalyzer = $arrayTypeAnalyzer;
        $this->countableTypeAnalyzer = $countableTypeAnalyzer;
        $this->stringTypeAnalyzer = $stringTypeAnalyzer;
        $this->typeUnwrapper = $typeUnwrapper;
    }
    public function isInObjectType(\PhpParser\Node $node, string $type) : bool
    {
        $objectType = $this->nodeTypeResolver->resolve($node);
        $desiredObjectType = new \PHPStan\Type\ObjectType($type);
        if ($objectType->isSuperTypeOf($desiredObjectType)->yes()) {
            return \true;
        }
        return $objectType->equals($desiredObjectType);
    }
    public function isPropertyBoolean(\PhpParser\Node\Stmt\Property $property) : bool
    {
        return $this->nodeTypeResolver->isPropertyBoolean($property);
    }
    /**
     * @param ObjectType|string $type
     */
    protected function isObjectType(\PhpParser\Node $node, $type) : bool
    {
        return $this->nodeTypeResolver->isObjectType($node, $type);
    }
    /**
     * @param string[]|ObjectType[] $requiredTypes
     */
    protected function isObjectTypes(\PhpParser\Node $node, array $requiredTypes) : bool
    {
        return $this->nodeTypeResolver->isObjectTypes($node, $requiredTypes);
    }
    protected function isReturnOfObjectType(\PhpParser\Node\Stmt\Return_ $return, string $objectType) : bool
    {
        if ($return->expr === null) {
            return \false;
        }
        $returnType = $this->getStaticType($return->expr);
        if (!$returnType instanceof \PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        return \is_a($returnType->getClassName(), $objectType, \true);
    }
    /**
     * @param Type[] $desiredTypes
     */
    protected function isSameObjectTypes(\PHPStan\Type\ObjectType $objectType, array $desiredTypes) : bool
    {
        foreach ($desiredTypes as $abstractClassConstructorParamType) {
            if ($abstractClassConstructorParamType->equals($objectType)) {
                return \true;
            }
        }
        return \false;
    }
    protected function isStringOrUnionStringOnlyType(\PhpParser\Node $node) : bool
    {
        return $this->stringTypeAnalyzer->isStringOrUnionStringOnlyType($node);
    }
    protected function isNumberType(\PhpParser\Node $node) : bool
    {
        return $this->nodeTypeResolver->isNumberType($node);
    }
    protected function isStaticType(\PhpParser\Node $node, string $staticTypeClass) : bool
    {
        return $this->nodeTypeResolver->isStaticType($node, $staticTypeClass);
    }
    protected function getStaticType(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        return $this->nodeTypeResolver->getStaticType($node);
    }
    protected function isNullableType(\PhpParser\Node $node) : bool
    {
        return $this->nodeTypeResolver->isNullableType($node);
    }
    protected function isNullableObjectType(\PhpParser\Node $node) : bool
    {
        return $this->nodeTypeResolver->isNullableObjectType($node);
    }
    protected function isNullableArrayType(\PhpParser\Node $node) : bool
    {
        return $this->nodeTypeResolver->isNullableArrayType($node);
    }
    protected function isCountableType(\PhpParser\Node $node) : bool
    {
        return $this->countableTypeAnalyzer->isCountableType($node);
    }
    protected function isArrayType(\PhpParser\Node $node) : bool
    {
        return $this->arrayTypeAnalyzer->isArrayType($node);
    }
    protected function getObjectType(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        return $this->nodeTypeResolver->resolve($node);
    }
    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     */
    protected function isMethodStaticCallOrClassMethodObjectType(\PhpParser\Node $node, string $type) : bool
    {
        if ($node instanceof \PhpParser\Node\Expr\MethodCall) {
            // method call is variable return
            return $this->isObjectType($node->var, $type);
        }
        if ($node instanceof \PhpParser\Node\Expr\StaticCall) {
            return $this->isObjectType($node->class, $type);
        }
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
                return \false;
            }
            return $this->isObjectType($classLike, $type);
        }
        return \false;
    }
}
