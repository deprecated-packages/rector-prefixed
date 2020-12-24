<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a6b37af0871\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class MethodCallManipulator
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var FluentChainMethodCallNodeAnalyzer
     */
    private $fluentChainMethodCallNodeAnalyzer;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer $fluentChainMethodCallNodeAnalyzer)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->fluentChainMethodCallNodeAnalyzer = $fluentChainMethodCallNodeAnalyzer;
    }
    /**
     * @return string[]
     */
    public function findMethodCallNamesOnVariable(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $variable) : array
    {
        $methodCallsOnVariable = $this->findMethodCallsOnVariable($variable);
        $methodCallNamesOnVariable = [];
        foreach ($methodCallsOnVariable as $methodCallOnVariable) {
            $methodName = $this->nodeNameResolver->getName($methodCallOnVariable->name);
            if ($methodName === null) {
                continue;
            }
            $methodCallNamesOnVariable[] = $methodName;
        }
        return \array_unique($methodCallNamesOnVariable);
    }
    /**
     * @return MethodCall[]
     */
    public function findMethodCallsIncludingChain(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : array
    {
        $chainMethodCalls = [];
        // 1. collect method chain call
        $currentMethodCallee = $methodCall->var;
        while ($currentMethodCallee instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            $chainMethodCalls[] = $currentMethodCallee;
            $currentMethodCallee = $currentMethodCallee->var;
        }
        // 2. collect on-same-variable calls
        $onVariableMethodCalls = [];
        if ($currentMethodCallee instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
            $onVariableMethodCalls = $this->findMethodCallsOnVariable($currentMethodCallee);
        }
        $methodCalls = \array_merge($chainMethodCalls, $onVariableMethodCalls);
        return $this->uniquateObjects($methodCalls);
    }
    public function findAssignToVariable(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign
    {
        /** @var Node|null $parentNode */
        $parentNode = $variable->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode === null) {
            return null;
        }
        $variableName = $this->nodeNameResolver->getName($variable);
        if ($variableName === null) {
            return null;
        }
        do {
            $assign = $this->findAssignToVariableName($parentNode, $variableName);
            if ($assign instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
                return $assign;
            }
            $parentNode = $this->resolvePreviousNodeInSameScope($parentNode);
        } while ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node && !$parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike);
        return null;
    }
    /**
     * @return MethodCall[]
     */
    public function findMethodCallsOnVariable(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $variable) : array
    {
        // get scope node, e.g. parent function call, method call or anonymous function
        /** @var ClassMethod|null $classMethod */
        $classMethod = $variable->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if ($classMethod === null) {
            return [];
        }
        $variableName = $this->nodeNameResolver->getName($variable);
        return $this->betterNodeFinder->find((array) $classMethod->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($variableName) : bool {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
                return \false;
            }
            // cover fluent interfaces too
            $callerNode = $this->fluentChainMethodCallNodeAnalyzer->resolveRootExpr($node);
            if (!$callerNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
                return \false;
            }
            return $this->nodeNameResolver->isName($callerNode, $variableName);
        });
    }
    /**
     * @see https://stackoverflow.com/a/4507991/1348344
     * @param object[] $objects
     * @return object[]
     *
     * @template T
     * @phpstan-param array<T>|T[] $objects
     * @phpstan-return array<T>|T[]
     */
    private function uniquateObjects(array $objects) : array
    {
        $uniqueObjects = [];
        foreach ($objects as $object) {
            if (\in_array($object, $uniqueObjects, \true)) {
                continue;
            }
            $uniqueObjects[] = $object;
        }
        // re-index
        return \array_values($uniqueObjects);
    }
    private function findAssignToVariableName(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $variableName) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        return $this->betterNodeFinder->findFirst($node, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($variableName) : bool {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
                return \false;
            }
            if (!$node->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
                return \false;
            }
            return $this->nodeNameResolver->isName($node->var, $variableName);
        });
    }
    private function resolvePreviousNodeInSameScope(\_PhpScoper0a6b37af0871\PhpParser\Node $parentNode) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $previousParentNode = $parentNode;
        $parentNode = $parentNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike) {
            // is about to leave → try previous expression
            $previousStatement = $previousParentNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT);
            if ($previousStatement instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression) {
                return $previousStatement->expr;
            }
        }
        return $parentNode;
    }
}
