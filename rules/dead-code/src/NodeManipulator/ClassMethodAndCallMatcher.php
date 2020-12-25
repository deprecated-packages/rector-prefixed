<?php

declare (strict_types=1);
namespace Rector\DeadCode\NodeManipulator;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class ClassMethodAndCallMatcher
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isMethodLikeCallMatchingClassMethod(\PhpParser\Node $node, \PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if ($node instanceof \PhpParser\Node\Expr\MethodCall) {
            return $this->isMethodCallMatchingClassMethod($node, $classMethod);
        }
        if ($node instanceof \PhpParser\Node\Expr\StaticCall) {
            return $this->isStaticCallMatchingClassMethod($node, $classMethod);
        }
        return \false;
    }
    private function isMethodCallMatchingClassMethod(\PhpParser\Node\Expr\MethodCall $methodCall, \PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var string $className */
        $className = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        /** @var string $classMethodName */
        $classMethodName = $this->nodeNameResolver->getName($classMethod);
        if (!$this->nodeNameResolver->isName($methodCall->name, $classMethodName)) {
            return \false;
        }
        $objectType = new \PHPStan\Type\ObjectType($className);
        $callerStaticType = $this->nodeTypeResolver->getStaticType($methodCall->var);
        return $objectType->isSuperTypeOf($callerStaticType)->yes();
    }
    private function isStaticCallMatchingClassMethod(\PhpParser\Node\Expr\StaticCall $staticCall, \PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var string $className */
        $className = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        /** @var string $methodName */
        $methodName = $this->nodeNameResolver->getName($classMethod);
        if (!$this->nodeNameResolver->isName($staticCall->name, $methodName)) {
            return \false;
        }
        $objectType = new \PHPStan\Type\ObjectType($className);
        $callerStaticType = $this->nodeTypeResolver->resolve($staticCall->class);
        if ($callerStaticType instanceof \PHPStan\Type\MixedType) {
            return \false;
        }
        return $objectType->isSuperTypeOf($callerStaticType)->yes();
    }
}
