<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Generic\NodeTypeAnalyzer;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParameterReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver;
final class CallTypeAnalyzer
{
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @param MethodCall|StaticCall $node
     * @return Type[]
     */
    public function resolveMethodParameterTypes(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : array
    {
        $callerType = $this->resolveCallerType($node);
        if (!$callerType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
            return [];
        }
        $callerClassName = $callerType->getClassName();
        return $this->getMethodParameterTypes($callerClassName, $node);
    }
    /**
     * @param StaticCall|MethodCall $node
     */
    private function resolveCallerType(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            return $this->nodeTypeResolver->getStaticType($node->var);
        }
        return $this->nodeTypeResolver->resolve($node->class);
    }
    /**
     * @param MethodCall|StaticCall $node
     * @return Type[]
     */
    private function getMethodParameterTypes(string $className, \_PhpScoper0a2ac50786fa\PhpParser\Node $node) : array
    {
        $classReflection = $this->reflectionProvider->getClass($className);
        $methodName = $this->nodeNameResolver->getName($node->name);
        if (!$methodName) {
            return [];
        }
        $scope = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope) {
            return [];
        }
        // method not found
        if (!$classReflection->hasMethod($methodName)) {
            return [];
        }
        $methodReflection = $classReflection->getMethod($methodName, $scope);
        $functionVariant = \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants());
        $parameterTypes = [];
        /** @var ParameterReflection $parameterReflection */
        foreach ($functionVariant->getParameters() as $parameterReflection) {
            $parameterTypes[] = $parameterReflection->getType();
        }
        return $parameterTypes;
    }
}
