<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\NodeTypeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @param MethodCall|StaticCall $node
     * @return Type[]
     */
    public function resolveMethodParameterTypes(\_PhpScopere8e811afab72\PhpParser\Node $node) : array
    {
        $callerType = $this->resolveCallerType($node);
        if (!$callerType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return [];
        }
        $callerClassName = $callerType->getClassName();
        return $this->getMethodParameterTypes($callerClassName, $node);
    }
    /**
     * @param StaticCall|MethodCall $node
     */
    private function resolveCallerType(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return $this->nodeTypeResolver->getStaticType($node->var);
        }
        return $this->nodeTypeResolver->resolve($node->class);
    }
    /**
     * @param MethodCall|StaticCall $node
     * @return Type[]
     */
    private function getMethodParameterTypes(string $className, \_PhpScopere8e811afab72\PhpParser\Node $node) : array
    {
        $classReflection = $this->reflectionProvider->getClass($className);
        $methodName = $this->nodeNameResolver->getName($node->name);
        if (!$methodName) {
            return [];
        }
        $scope = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \_PhpScopere8e811afab72\PHPStan\Analyser\Scope) {
            return [];
        }
        // method not found
        if (!$classReflection->hasMethod($methodName)) {
            return [];
        }
        $methodReflection = $classReflection->getMethod($methodName, $scope);
        $functionVariant = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants());
        $parameterTypes = [];
        /** @var ParameterReflection $parameterReflection */
        foreach ($functionVariant->getParameters() as $parameterReflection) {
            $parameterTypes[] = $parameterReflection->getType();
        }
        return $parameterTypes;
    }
}
