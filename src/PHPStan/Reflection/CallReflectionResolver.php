<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PHPStan\Reflection;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Broker\FunctionNotFoundException;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptor;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\Core\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverRegistry;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoperb75b35f52b74\Rector\Core\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverRegistry $typeToCallReflectionResolverRegistry)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->typeToCallReflectionResolverRegistry = $typeToCallReflectionResolverRegistry;
    }
    public function resolveConstructor(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_ $new) : ?\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection
    {
        /** @var Scope|null $scope */
        $scope = $new->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            return null;
        }
        $classType = $this->nodeTypeResolver->resolve($new->class);
        if ($classType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            return $this->matchConstructorMethodInUnionType($classType, $scope);
        }
        if (!$classType->hasMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT)->yes()) {
            return null;
        }
        return $classType->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT, $scope);
    }
    /**
     * @param FuncCall|MethodCall|StaticCall $node
     * @return MethodReflection|FunctionReflection|null
     */
    public function resolveCall(\_PhpScoperb75b35f52b74\PhpParser\Node $node)
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
            return $this->resolveFunctionCall($node);
        }
        return $this->resolveMethodCall($node);
    }
    /**
     * @param FunctionReflection|MethodReflection|null $reflection
     * @param FuncCall|MethodCall|StaticCall|New_ $node
     */
    public function resolveParametersAcceptor($reflection, \_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptor
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
            return \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($variants);
        }
        /** @var Scope|null $scope */
        $scope = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            return null;
        }
        return \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $node->args, $variants);
    }
    private function matchConstructorMethodInUnionType(\_PhpScoperb75b35f52b74\PHPStan\Type\UnionType $unionType, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : ?\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection
    {
        foreach ($unionType->getTypes() as $unionedType) {
            if (!$unionedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
                continue;
            }
            if (!$unionedType->hasMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT)->yes()) {
                continue;
            }
            return $unionedType->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT, $scope);
        }
        return null;
    }
    /**
     * @return FunctionReflection|MethodReflection|null
     */
    private function resolveFunctionCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall)
    {
        /** @var Scope|null $scope */
        $scope = $funcCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($funcCall->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            try {
                return $this->reflectionProvider->getFunction($funcCall->name, $scope);
            } catch (\_PhpScoperb75b35f52b74\PHPStan\Broker\FunctionNotFoundException $functionNotFoundException) {
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
    private function resolveMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection
    {
        /** @var Scope|null $scope */
        $scope = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            return null;
        }
        $classType = $this->nodeTypeResolver->resolve($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall ? $node->var : $node->class);
        $methodName = $this->nodeNameResolver->getName($node->name);
        if ($methodName === null || !$classType->hasMethod($methodName)->yes()) {
            return null;
        }
        return $classType->getMethod($methodName, $scope);
    }
}
