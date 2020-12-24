<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DeadCode\NodeManipulator;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isMethodLikeCallMatchingClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            return $this->isMethodCallMatchingClassMethod($node, $classMethod);
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
            return $this->isStaticCallMatchingClassMethod($node, $classMethod);
        }
        return \false;
    }
    private function isMethodCallMatchingClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var string $className */
        $className = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        /** @var string $classMethodName */
        $classMethodName = $this->nodeNameResolver->getName($classMethod);
        if (!$this->nodeNameResolver->isName($methodCall->name, $classMethodName)) {
            return \false;
        }
        $objectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($className);
        $callerStaticType = $this->nodeTypeResolver->getStaticType($methodCall->var);
        return $objectType->isSuperTypeOf($callerStaticType)->yes();
    }
    private function isStaticCallMatchingClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall $staticCall, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var string $className */
        $className = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        /** @var string $methodName */
        $methodName = $this->nodeNameResolver->getName($classMethod);
        if (!$this->nodeNameResolver->isName($staticCall->name, $methodName)) {
            return \false;
        }
        $objectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($className);
        $callerStaticType = $this->nodeTypeResolver->resolve($staticCall->class);
        if ($callerStaticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
            return \false;
        }
        return $objectType->isSuperTypeOf($callerStaticType)->yes();
    }
}
