<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PHPStan\Reflection;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Broker\FunctionNotFoundException;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\Core\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverRegistry;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
final class CallReflectionResolver
{
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var TypeToCallReflectionResolverRegistry
     */
    private $typeToCallReflectionResolverRegistry;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScopere8e811afab72\Rector\Core\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverRegistry $typeToCallReflectionResolverRegistry)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->typeToCallReflectionResolverRegistry = $typeToCallReflectionResolverRegistry;
    }
    public function resolveConstructor(\_PhpScopere8e811afab72\PhpParser\Node\Expr\New_ $new) : ?\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection
    {
        /** @var Scope|null $scope */
        $scope = $new->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            return null;
        }
        $classType = $this->nodeTypeResolver->resolve($new->class);
        if ($classType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return $this->matchConstructorMethodInUnionType($classType, $scope);
        }
        if (!$classType->hasMethod(\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT)->yes()) {
            return null;
        }
        return $classType->getMethod(\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT, $scope);
    }
    /**
     * @param FuncCall|MethodCall|StaticCall $node
     * @return MethodReflection|FunctionReflection|null
     */
    public function resolveCall(\_PhpScopere8e811afab72\PhpParser\Node $node)
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
            return $this->resolveFunctionCall($node);
        }
        return $this->resolveMethodCall($node);
    }
    /**
     * @param FunctionReflection|MethodReflection|null $reflection
     * @param FuncCall|MethodCall|StaticCall|New_ $node
     */
    public function resolveParametersAcceptor($reflection, \_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor
    {
        if ($reflection === null) {
            return null;
        }
        $variants = $reflection->getVariants();
        $nbVariants = \count($variants);
        if ($nbVariants === 0) {
            return null;
        }
        if ($nbVariants === 1) {
            return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($variants);
        }
        /** @var Scope|null $scope */
        $scope = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            return null;
        }
        return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $node->args, $variants);
    }
    private function matchConstructorMethodInUnionType(\_PhpScopere8e811afab72\PHPStan\Type\UnionType $unionType, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : ?\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection
    {
        foreach ($unionType->getTypes() as $unionedType) {
            if (!$unionedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
                continue;
            }
            if (!$unionedType->hasMethod(\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT)->yes()) {
                continue;
            }
            return $unionedType->getMethod(\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT, $scope);
        }
        return null;
    }
    /**
     * @return FunctionReflection|MethodReflection|null
     */
    private function resolveFunctionCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall)
    {
        /** @var Scope|null $scope */
        $scope = $funcCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($funcCall->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            try {
                return $this->reflectionProvider->getFunction($funcCall->name, $scope);
            } catch (\_PhpScopere8e811afab72\PHPStan\Broker\FunctionNotFoundException $functionNotFoundException) {
                return null;
            }
        }
        if ($scope === null) {
            return null;
        }
        return $this->typeToCallReflectionResolverRegistry->resolve($scope->getType($funcCall->name), $scope);
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function resolveMethodCall(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection
    {
        /** @var Scope|null $scope */
        $scope = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            return null;
        }
        $classType = $this->nodeTypeResolver->resolve($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall ? $node->var : $node->class);
        $methodName = $this->nodeNameResolver->getName($node->name);
        if ($methodName === null || !$classType->hasMethod($methodName)->yes()) {
            return null;
        }
        return $classType->getMethod($methodName, $scope);
    }
}
