<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\PHPStan\Reflection;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Broker\FunctionNotFoundException;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptor;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverRegistry;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverRegistry $typeToCallReflectionResolverRegistry)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->typeToCallReflectionResolverRegistry = $typeToCallReflectionResolverRegistry;
    }
    public function resolveConstructor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_ $new) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection
    {
        /** @var Scope|null $scope */
        $scope = $new->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            return null;
        }
        $classType = $this->nodeTypeResolver->resolve($new->class);
        if ($classType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType) {
            return $this->matchConstructorMethodInUnionType($classType, $scope);
        }
        if (!$classType->hasMethod(\_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName::CONSTRUCT)->yes()) {
            return null;
        }
        return $classType->getMethod(\_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName::CONSTRUCT, $scope);
    }
    /**
     * @param FuncCall|MethodCall|StaticCall $node
     * @return MethodReflection|FunctionReflection|null
     */
    public function resolveCall(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node)
    {
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall) {
            return $this->resolveFunctionCall($node);
        }
        return $this->resolveMethodCall($node);
    }
    /**
     * @param FunctionReflection|MethodReflection|null $reflection
     * @param FuncCall|MethodCall|StaticCall|New_ $node
     */
    public function resolveParametersAcceptor($reflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptor
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
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($variants);
        }
        /** @var Scope|null $scope */
        $scope = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            return null;
        }
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $node->args, $variants);
    }
    private function matchConstructorMethodInUnionType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType $unionType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection
    {
        foreach ($unionType->getTypes() as $unionedType) {
            if (!$unionedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName) {
                continue;
            }
            if (!$unionedType->hasMethod(\_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName::CONSTRUCT)->yes()) {
                continue;
            }
            return $unionedType->getMethod(\_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName::CONSTRUCT, $scope);
        }
        return null;
    }
    /**
     * @return FunctionReflection|MethodReflection|null
     */
    private function resolveFunctionCall(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $funcCall)
    {
        /** @var Scope|null $scope */
        $scope = $funcCall->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($funcCall->name instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name) {
            try {
                return $this->reflectionProvider->getFunction($funcCall->name, $scope);
            } catch (\_PhpScoper2a4e7ab1ecbc\PHPStan\Broker\FunctionNotFoundException $functionNotFoundException) {
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
    private function resolveMethodCall(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection
    {
        /** @var Scope|null $scope */
        $scope = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            return null;
        }
        $classType = $this->nodeTypeResolver->resolve($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall ? $node->var : $node->class);
        $methodName = $this->nodeNameResolver->getName($node->name);
        if ($methodName === null) {
            return null;
        }
        if (!$classType->hasMethod($methodName)->yes()) {
            return null;
        }
        return $classType->getMethod($methodName, $scope);
    }
}
