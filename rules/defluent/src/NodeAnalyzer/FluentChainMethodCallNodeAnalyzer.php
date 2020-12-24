<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\NodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
/**
 * Utils for chain of MethodCall Node:
 * "$this->methodCall()->chainedMethodCall()"
 */
final class FluentChainMethodCallNodeAnalyzer
{
    /**
     * Types that look like fluent interface, but actually create a new object.
     * Should be skipped, as they return different object. Not an fluent interface!
     *
     * @var string[]
     */
    private const KNOWN_FACTORY_FLUENT_TYPES = ['_PhpScopere8e811afab72\\PHPStan\\Analyser\\MutatingScope'];
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * Checks that in:
     * $this->someCall();
     *
     * The method is fluent class method === returns self
     * public function someClassMethod()
     * {
     *      return $this;
     * }
     */
    public function isFluentClassMethodOfMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if ($methodCall->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall || $methodCall->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        $calleeStaticType = $this->nodeTypeResolver->getStaticType($methodCall->var);
        // we're not sure
        if ($calleeStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return \false;
        }
        $methodReturnStaticType = $this->nodeTypeResolver->getStaticType($methodCall);
        // is fluent type
        if (!$calleeStaticType->equals($methodReturnStaticType)) {
            return \false;
        }
        if ($calleeStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            foreach (self::KNOWN_FACTORY_FLUENT_TYPES as $knownFactoryFluentTypes) {
                if (\is_a($calleeStaticType->getClassName(), $knownFactoryFluentTypes, \true)) {
                    return \false;
                }
            }
        }
        return \true;
    }
    public function isLastChainMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        // is chain method call
        if (!$methodCall->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall && !$methodCall->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_) {
            return \false;
        }
        $nextNode = $methodCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        // is last chain call
        return $nextNode === null;
    }
    /**
     * @return string[]|null[]
     */
    public function collectMethodCallNamesInChain(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $desiredMethodCall) : array
    {
        $methodCalls = $this->collectAllMethodCallsInChain($desiredMethodCall);
        $methodNames = [];
        foreach ($methodCalls as $methodCall) {
            $methodNames[] = $this->nodeNameResolver->getName($methodCall->name);
        }
        return $methodNames;
    }
    /**
     * @return MethodCall[]
     */
    public function collectAllMethodCallsInChain(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : array
    {
        $chainMethodCalls = [$methodCall];
        // traverse up
        $currentNode = $methodCall->var;
        while ($currentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            $chainMethodCalls[] = $currentNode;
            $currentNode = $currentNode->var;
        }
        // traverse down
        if (\count($chainMethodCalls) === 1) {
            $currentNode = $methodCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            while ($currentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
                $chainMethodCalls[] = $currentNode;
                $currentNode = $currentNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            }
        }
        return $chainMethodCalls;
    }
    /**
     * @return MethodCall[]
     */
    public function collectAllMethodCallsInChainWithoutRootOne(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : array
    {
        $chainMethodCalls = $this->collectAllMethodCallsInChain($methodCall);
        foreach ($chainMethodCalls as $key => $chainMethodCall) {
            if (!$chainMethodCall->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall && !$chainMethodCall->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_) {
                unset($chainMethodCalls[$key]);
                break;
            }
        }
        return \array_values($chainMethodCalls);
    }
    /**
     * Checks "$this->someMethod()->anotherMethod()"
     *
     * @param string[] $methods
     */
    public function isTypeAndChainCalls(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Type\Type $type, array $methods) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        // node chaining is in reverse order than code
        $methods = \array_reverse($methods);
        foreach ($methods as $method) {
            $activeMethodName = $this->nodeNameResolver->getName($node->name);
            if ($activeMethodName !== $method) {
                return \false;
            }
            $node = $node->var;
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
                continue;
            }
        }
        $variableType = $this->nodeTypeResolver->resolve($node);
        if ($variableType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return \false;
        }
        return $variableType->isSuperTypeOf($type)->yes();
    }
    public function resolveRootExpr(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : \_PhpScopere8e811afab72\PhpParser\Node
    {
        $callerNode = $methodCall->var;
        while ($callerNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall || $callerNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            $callerNode = $callerNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall ? $callerNode->class : $callerNode->var;
        }
        return $callerNode;
    }
    public function resolveRootMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall
    {
        $callerNode = $methodCall->var;
        while ($callerNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall && $callerNode->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            $callerNode = $callerNode->var;
        }
        if ($callerNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return $callerNode;
        }
        return null;
    }
}
