<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\NodeManipulator;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isMethodLikeCallMatchingClassMethod(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return $this->isMethodCallMatchingClassMethod($node, $classMethod);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            return $this->isStaticCallMatchingClassMethod($node, $classMethod);
        }
        return \false;
    }
    private function isMethodCallMatchingClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var string $className */
        $className = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        /** @var string $classMethodName */
        $classMethodName = $this->nodeNameResolver->getName($classMethod);
        if (!$this->nodeNameResolver->isName($methodCall->name, $classMethodName)) {
            return \false;
        }
        $objectType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($className);
        $callerStaticType = $this->nodeTypeResolver->getStaticType($methodCall->var);
        return $objectType->isSuperTypeOf($callerStaticType)->yes();
    }
    private function isStaticCallMatchingClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall $staticCall, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var string $className */
        $className = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        /** @var string $methodName */
        $methodName = $this->nodeNameResolver->getName($classMethod);
        if (!$this->nodeNameResolver->isName($staticCall->name, $methodName)) {
            return \false;
        }
        $objectType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($className);
        $callerStaticType = $this->nodeTypeResolver->resolve($staticCall->class);
        if ($callerStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return \false;
        }
        return $objectType->isSuperTypeOf($callerStaticType)->yes();
    }
}
