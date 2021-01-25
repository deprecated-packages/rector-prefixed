<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Manipulator;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Class_;
use Rector\Core\PhpParser\Node\Value\ValueResolver;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PHPUnit\Collector\FormerVariablesByMethodCollector;
use Rector\PostRector\Collector\NodesToRemoveCollector;
use Rector\SymfonyPHPUnit\Naming\ServiceNaming;
use Rector\SymfonyPHPUnit\Node\KernelTestCaseNodeAnalyzer;
use RectorPrefix20210125\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class OnContainerGetCallManipulator
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
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
    public function __construct(\RectorPrefix20210125\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\SymfonyPHPUnit\Node\KernelTestCaseNodeAnalyzer $kernelTestCaseNodeAnalyzer, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector, \Rector\SymfonyPHPUnit\Naming\ServiceNaming $serviceNaming, \Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \Rector\PHPUnit\Collector\FormerVariablesByMethodCollector $formerVariablesByMethodCollector)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
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
    public function replaceFormerVariablesWithPropertyFetch(\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($class->stmts, function (\PhpParser\Node $node) : ?PropertyFetch {
            if (!$node instanceof \PhpParser\Node\Expr\Variable) {
                return null;
            }
            $variableName = $this->nodeNameResolver->getName($node);
            if ($variableName === null) {
                return null;
            }
            /** @var string|null $methodName */
            $methodName = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
            if ($methodName === null) {
                return null;
            }
            $serviceType = $this->formerVariablesByMethodCollector->getTypeByVariableByMethod($methodName, $variableName);
            if ($serviceType === null) {
                return null;
            }
            $propertyName = $this->serviceNaming->resolvePropertyNameFromServiceType($serviceType);
            return new \PhpParser\Node\Expr\PropertyFetch(new \PhpParser\Node\Expr\Variable('this'), $propertyName);
        });
    }
    public function removeAndCollectFormerAssignedVariables(\PhpParser\Node\Stmt\Class_ $class, bool $skipSetUpMethod = \true) : void
    {
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($class->stmts, function (\PhpParser\Node $node) use($skipSetUpMethod) : ?PropertyFetch {
            if (!$node instanceof \PhpParser\Node\Expr\MethodCall) {
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
            $parentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode instanceof \PhpParser\Node\Expr\Assign) {
                $this->processAssign($node, $parentNode, $type);
                return null;
            }
            $propertyName = $this->serviceNaming->resolvePropertyNameFromServiceType($type);
            return new \PhpParser\Node\Expr\PropertyFetch(new \PhpParser\Node\Expr\Variable('this'), $propertyName);
        });
    }
    private function processAssign(\PhpParser\Node\Expr\MethodCall $methodCall, \PhpParser\Node\Expr\Assign $assign, string $type) : void
    {
        $variableName = $this->nodeNameResolver->getName($assign->var);
        if ($variableName === null) {
            return;
        }
        /** @var string $methodName */
        $methodName = $methodCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        $this->formerVariablesByMethodCollector->addMethodVariable($methodName, $variableName, $type);
        $this->nodesToRemoveCollector->addNodeToRemove($assign);
    }
}
