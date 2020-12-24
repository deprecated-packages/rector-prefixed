<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Manipulator;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Collector\FormerVariablesByMethodCollector;
use _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\NodesToRemoveCollector;
use _PhpScoper2a4e7ab1ecbc\Rector\SymfonyPHPUnit\Naming\ServiceNaming;
use _PhpScoper2a4e7ab1ecbc\Rector\SymfonyPHPUnit\Node\KernelTestCaseNodeAnalyzer;
final class OnContainerGetCallManipulator
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var ServiceNaming
     */
    private $serviceNaming;
    /**
     * @var KernelTestCaseNodeAnalyzer
     */
    private $kernelTestCaseNodeAnalyzer;
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    /**
     * @var NodesToRemoveCollector
     */
    private $nodesToRemoveCollector;
    /**
     * @var FormerVariablesByMethodCollector
     */
    private $formerVariablesByMethodCollector;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoper2a4e7ab1ecbc\Rector\SymfonyPHPUnit\Node\KernelTestCaseNodeAnalyzer $kernelTestCaseNodeAnalyzer, \_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector, \_PhpScoper2a4e7ab1ecbc\Rector\SymfonyPHPUnit\Naming\ServiceNaming $serviceNaming, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \_PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Collector\FormerVariablesByMethodCollector $formerVariablesByMethodCollector)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->serviceNaming = $serviceNaming;
        $this->kernelTestCaseNodeAnalyzer = $kernelTestCaseNodeAnalyzer;
        $this->valueResolver = $valueResolver;
        $this->nodesToRemoveCollector = $nodesToRemoveCollector;
        $this->formerVariablesByMethodCollector = $formerVariablesByMethodCollector;
    }
    /**
     * E.g. $someService ↓
     * $this->someService
     */
    public function replaceFormerVariablesWithPropertyFetch(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable($class->stmts, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?PropertyFetch {
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
                return null;
            }
            $variableName = $this->nodeNameResolver->getName($node);
            if ($variableName === null) {
                return null;
            }
            /** @var string|null $methodName */
            $methodName = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
            if ($methodName === null) {
                return null;
            }
            $serviceType = $this->formerVariablesByMethodCollector->getTypeByVariableByMethod($methodName, $variableName);
            if ($serviceType === null) {
                return null;
            }
            $propertyName = $this->serviceNaming->resolvePropertyNameFromServiceType($serviceType);
            return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable('this'), $propertyName);
        });
    }
    public function removeAndCollectFormerAssignedVariables(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class, bool $skipSetUpMethod = \true) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable($class->stmts, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use($skipSetUpMethod) : ?PropertyFetch {
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall) {
                return null;
            }
            if ($skipSetUpMethod && $this->kernelTestCaseNodeAnalyzer->isSetUpOrEmptyMethod($node)) {
                return null;
            }
            if (!$this->kernelTestCaseNodeAnalyzer->isOnContainerGetMethodCall($node)) {
                return null;
            }
            $type = $this->valueResolver->getValue($node->args[0]->value);
            if ($type === null) {
                return null;
            }
            $parentNode = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign) {
                $this->processAssign($node, $parentNode, $type);
                return null;
            }
            $propertyName = $this->serviceNaming->resolvePropertyNameFromServiceType($type);
            return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable('this'), $propertyName);
        });
    }
    private function processAssign(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign $assign, string $type) : void
    {
        $variableName = $this->nodeNameResolver->getName($assign->var);
        if ($variableName === null) {
            return;
        }
        /** @var string $methodName */
        $methodName = $methodCall->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        $this->formerVariablesByMethodCollector->addMethodVariable($methodName, $variableName, $type);
        $this->nodesToRemoveCollector->addNodeToRemove($assign);
    }
}
