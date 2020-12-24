<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\Manipulator;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Collector\FormerVariablesByMethodCollector;
use _PhpScoperb75b35f52b74\Rector\PostRector\Collector\NodesToRemoveCollector;
use _PhpScoperb75b35f52b74\Rector\SymfonyPHPUnit\Naming\ServiceNaming;
use _PhpScoperb75b35f52b74\Rector\SymfonyPHPUnit\Node\KernelTestCaseNodeAnalyzer;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoperb75b35f52b74\Rector\SymfonyPHPUnit\Node\KernelTestCaseNodeAnalyzer $kernelTestCaseNodeAnalyzer, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector, \_PhpScoperb75b35f52b74\Rector\SymfonyPHPUnit\Naming\ServiceNaming $serviceNaming, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \_PhpScoperb75b35f52b74\Rector\PHPUnit\Collector\FormerVariablesByMethodCollector $formerVariablesByMethodCollector)
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
    public function replaceFormerVariablesWithPropertyFetch(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable($class->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?PropertyFetch {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
                return null;
            }
            $variableName = $this->nodeNameResolver->getName($node);
            if ($variableName === null) {
                return null;
            }
            /** @var string|null $methodName */
            $methodName = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
            if ($methodName === null) {
                return null;
            }
            $serviceType = $this->formerVariablesByMethodCollector->getTypeByVariableByMethod($methodName, $variableName);
            if ($serviceType === null) {
                return null;
            }
            $propertyName = $this->serviceNaming->resolvePropertyNameFromServiceType($serviceType);
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this'), $propertyName);
        });
    }
    public function removeAndCollectFormerAssignedVariables(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, bool $skipSetUpMethod = \true) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable($class->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($skipSetUpMethod) : ?PropertyFetch {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
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
            $parentNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
                $this->processAssign($node, $parentNode, $type);
                return null;
            }
            $propertyName = $this->serviceNaming->resolvePropertyNameFromServiceType($type);
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this'), $propertyName);
        });
    }
    private function processAssign(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign, string $type) : void
    {
        $variableName = $this->nodeNameResolver->getName($assign->var);
        if ($variableName === null) {
            return;
        }
        /** @var string $methodName */
        $methodName = $methodCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        $this->formerVariablesByMethodCollector->addMethodVariable($methodName, $variableName, $type);
        $this->nodesToRemoveCollector->addNodeToRemove($assign);
    }
}
