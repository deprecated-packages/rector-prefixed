<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\Manipulator;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PHPUnit\Collector\FormerVariablesByMethodCollector;
use _PhpScopere8e811afab72\Rector\PostRector\Collector\NodesToRemoveCollector;
use _PhpScopere8e811afab72\Rector\SymfonyPHPUnit\Naming\ServiceNaming;
use _PhpScopere8e811afab72\Rector\SymfonyPHPUnit\Node\KernelTestCaseNodeAnalyzer;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\SymfonyPHPUnit\Node\KernelTestCaseNodeAnalyzer $kernelTestCaseNodeAnalyzer, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector, \_PhpScopere8e811afab72\Rector\SymfonyPHPUnit\Naming\ServiceNaming $serviceNaming, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \_PhpScopere8e811afab72\Rector\PHPUnit\Collector\FormerVariablesByMethodCollector $formerVariablesByMethodCollector)
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
    public function replaceFormerVariablesWithPropertyFetch(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable($class->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : ?PropertyFetch {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
                return null;
            }
            $variableName = $this->nodeNameResolver->getName($node);
            if ($variableName === null) {
                return null;
            }
            /** @var string|null $methodName */
            $methodName = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
            if ($methodName === null) {
                return null;
            }
            $serviceType = $this->formerVariablesByMethodCollector->getTypeByVariableByMethod($methodName, $variableName);
            if ($serviceType === null) {
                return null;
            }
            $propertyName = $this->serviceNaming->resolvePropertyNameFromServiceType($serviceType);
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), $propertyName);
        });
    }
    public function removeAndCollectFormerAssignedVariables(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, bool $skipSetUpMethod = \true) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable($class->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($skipSetUpMethod) : ?PropertyFetch {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
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
            $parentNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                $this->processAssign($node, $parentNode, $type);
                return null;
            }
            $propertyName = $this->serviceNaming->resolvePropertyNameFromServiceType($type);
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), $propertyName);
        });
    }
    private function processAssign(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign, string $type) : void
    {
        $variableName = $this->nodeNameResolver->getName($assign->var);
        if ($variableName === null) {
            return;
        }
        /** @var string $methodName */
        $methodName = $methodCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        $this->formerVariablesByMethodCollector->addMethodVariable($methodName, $variableName, $type);
        $this->nodesToRemoveCollector->addNodeToRemove($assign);
    }
}
