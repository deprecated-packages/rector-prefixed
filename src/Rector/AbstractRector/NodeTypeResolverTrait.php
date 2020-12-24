<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\TypeAnalyzer\CountableTypeAnalyzer;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\TypeAnalyzer\StringTypeAnalyzer;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
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
    public function autowireNodeTypeResolverTrait(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer $arrayTypeAnalyzer, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\TypeAnalyzer\CountableTypeAnalyzer $countableTypeAnalyzer, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\TypeAnalyzer\StringTypeAnalyzer $stringTypeAnalyzer, \_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->arrayTypeAnalyzer = $arrayTypeAnalyzer;
        $this->countableTypeAnalyzer = $countableTypeAnalyzer;
        $this->stringTypeAnalyzer = $stringTypeAnalyzer;
        $this->typeUnwrapper = $typeUnwrapper;
    }
    public function isInObjectType(\_PhpScoperb75b35f52b74\PhpParser\Node $node, string $type) : bool
    {
        $objectType = $this->nodeTypeResolver->resolve($node);
        $desiredObjectType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($type);
        if ($objectType->isSuperTypeOf($desiredObjectType)->yes()) {
            return \true;
        }
        return $objectType->equals($desiredObjectType);
    }
    public function isPropertyBoolean(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : bool
    {
        return $this->nodeTypeResolver->isPropertyBoolean($property);
    }
    /**
     * @param ObjectType|string $type
     */
    protected function isObjectType(\_PhpScoperb75b35f52b74\PhpParser\Node $node, $type) : bool
    {
        return $this->nodeTypeResolver->isObjectType($node, $type);
    }
    /**
     * @param string[]|ObjectType[] $requiredTypes
     */
    protected function isObjectTypes(\_PhpScoperb75b35f52b74\PhpParser\Node $node, array $requiredTypes) : bool
    {
        foreach ($requiredTypes as $requiredType) {
            if ($this->isObjectType($node, $requiredType)) {
                return \true;
            }
        }
        return \false;
    }
    protected function isReturnOfObjectType(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_ $return, string $objectType) : bool
    {
        if ($return->expr === null) {
            return \false;
        }
        $returnType = $this->getStaticType($return->expr);
        if (!$returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        return \is_a($returnType->getClassName(), $objectType, \true);
    }
    /**
     * @param Type[] $desiredTypes
     */
    protected function isSameObjectTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType $objectType, array $desiredTypes) : bool
    {
        foreach ($desiredTypes as $abstractClassConstructorParamType) {
            if ($abstractClassConstructorParamType->equals($objectType)) {
                return \true;
            }
        }
        return \false;
    }
    protected function isStringOrUnionStringOnlyType(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        return $this->stringTypeAnalyzer->isStringOrUnionStringOnlyType($node);
    }
    protected function isNumberType(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        return $this->nodeTypeResolver->isNumberType($node);
    }
    protected function isStaticType(\_PhpScoperb75b35f52b74\PhpParser\Node $node, string $staticTypeClass) : bool
    {
        return $this->nodeTypeResolver->isStaticType($node, $staticTypeClass);
    }
    protected function getStaticType(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->nodeTypeResolver->getStaticType($node);
    }
    protected function isNullableType(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        return $this->nodeTypeResolver->isNullableType($node);
    }
    protected function isNullableObjectType(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        return $this->nodeTypeResolver->isNullableObjectType($node);
    }
    protected function isNullableArrayType(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        return $this->nodeTypeResolver->isNullableArrayType($node);
    }
    protected function isCountableType(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        return $this->countableTypeAnalyzer->isCountableType($node);
    }
    protected function isArrayType(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        return $this->arrayTypeAnalyzer->isArrayType($node);
    }
    protected function getObjectType(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->nodeTypeResolver->resolve($node);
    }
    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     */
    protected function isMethodStaticCallOrClassMethodObjectType(\_PhpScoperb75b35f52b74\PhpParser\Node $node, string $type) : bool
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            if ($node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
                return $this->isObjectType($node->var, $type);
            }
            // method call is variable return
            return $this->isObjectType($node->var, $type);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
            return $this->isObjectType($node->class, $type);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
            /** @var Class_|null $classLike */
            $classLike = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            if ($classLike === null) {
                return \false;
            }
            return $this->isObjectType($classLike, $type);
        }
        return \false;
    }
}
