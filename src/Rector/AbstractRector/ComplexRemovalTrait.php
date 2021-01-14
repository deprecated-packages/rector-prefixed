<?php

declare (strict_types=1);
namespace Rector\Core\Rector\AbstractRector;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Node\Manipulator\PropertyManipulator;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\Core\ValueObject\MethodName;
use Rector\DeadCode\NodeManipulator\LivingCodeManipulator;
use Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use Rector\NodeRemoval\AssignRemover;
use Rector\NodeRemoval\ClassMethodRemover;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PostRector\Collector\NodesToRemoveCollector;
/**
 * Located in another trait ↓
 * @property NodesToRemoveCollector $nodesToRemoveCollector
 */
trait ComplexRemovalTrait
{
    /**
     * @var ParsedNodeCollector
     */
    protected $parsedNodeCollector;
    /**
     * @var LivingCodeManipulator
     */
    protected $livingCodeManipulator;
    /**
     * @var BetterStandardPrinter
     */
    protected $betterStandardPrinter;
    /**
     * @var PropertyManipulator
     */
    private $propertyManipulator;
    /**
     * @var ClassMethodRemover
     */
    private $classMethodRemover;
    /**
     * @var AssignRemover
     */
    private $assignRemover;
    /**
     * @required
     */
    public function autowireComplexRemovalTrait(\Rector\Core\PhpParser\Node\Manipulator\PropertyManipulator $propertyManipulator, \Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector, \Rector\DeadCode\NodeManipulator\LivingCodeManipulator $livingCodeManipulator, \Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \Rector\NodeRemoval\ClassMethodRemover $classMethodRemover, \Rector\NodeRemoval\AssignRemover $assignRemover) : void
    {
        $this->parsedNodeCollector = $parsedNodeCollector;
        $this->propertyManipulator = $propertyManipulator;
        $this->livingCodeManipulator = $livingCodeManipulator;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->classMethodRemover = $classMethodRemover;
        $this->assignRemover = $assignRemover;
    }
    protected function removeClassMethodAndUsages(\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->classMethodRemover->removeClassMethodAndUsages($classMethod);
    }
    /**
     * @param string[] $classMethodNamesToSkip
     */
    protected function removePropertyAndUsages(\PhpParser\Node\Stmt\Property $property, array $classMethodNamesToSkip = []) : void
    {
        $shouldKeepProperty = \false;
        $propertyFetches = $this->propertyManipulator->getPrivatePropertyFetches($property);
        foreach ($propertyFetches as $propertyFetch) {
            if ($this->shouldSkipPropertyForClassMethod($propertyFetch, $classMethodNamesToSkip)) {
                $shouldKeepProperty = \true;
                continue;
            }
            // remove assigns
            $assign = $this->resolveAssign($propertyFetch);
            $this->assignRemover->removeAssignNode($assign);
            $this->removeConstructorDependency($assign);
        }
        if ($shouldKeepProperty) {
            return;
        }
        // remove __construct param
        /** @var Property $property */
        $this->removeNode($property);
        foreach ($property->props as $prop) {
            if (!$this->nodesToRemoveCollector->isNodeRemoved($prop)) {
                // if the property has at least one node left -> return
                return;
            }
        }
        $this->removeNode($property);
    }
    /**
     * @param StaticPropertyFetch|PropertyFetch $expr
     * @param string[] $classMethodNamesToSkip
     */
    private function shouldSkipPropertyForClassMethod(\PhpParser\Node\Expr $expr, array $classMethodNamesToSkip) : bool
    {
        /** @var ClassMethod|null $classMethodNode */
        $classMethodNode = $expr->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if ($classMethodNode === null) {
            return \false;
        }
        $classMethodName = $this->getName($classMethodNode);
        return \in_array($classMethodName, $classMethodNamesToSkip, \true);
    }
    /**
     * @param PropertyFetch|StaticPropertyFetch $expr
     */
    private function resolveAssign(\PhpParser\Node\Expr $expr) : \PhpParser\Node\Expr\Assign
    {
        $assign = $expr->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        while ($assign !== null && !$assign instanceof \PhpParser\Node\Expr\Assign) {
            $assign = $assign->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        if (!$assign instanceof \PhpParser\Node\Expr\Assign) {
            throw new \Rector\Core\Exception\ShouldNotHappenException("Can't handle this situation");
        }
        return $assign;
    }
    private function removeConstructorDependency(\PhpParser\Node\Expr\Assign $assign) : void
    {
        $methodName = $assign->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        if ($methodName !== \Rector\Core\ValueObject\MethodName::CONSTRUCT) {
            return;
        }
        $class = $assign->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$class instanceof \PhpParser\Node\Stmt\Class_) {
            return;
        }
        $constructClassMethod = $class->getMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if (!$constructClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return;
        }
        $constructClassMethodStmts = $constructClassMethod->stmts;
        foreach ($constructClassMethod->getParams() as $param) {
            $variable = $this->betterNodeFinder->findFirst($constructClassMethodStmts, function (\PhpParser\Node $node) use($param) : bool {
                return $this->betterStandardPrinter->areNodesEqual($param->var, $node);
            });
            if ($variable === null) {
                continue;
            }
            if ($this->isExpressionVariableNotAssign($variable)) {
                continue;
            }
            if (!$this->betterStandardPrinter->areNodesEqual($param->var, $assign->expr)) {
                continue;
            }
            $this->removeNode($param);
        }
    }
    private function isExpressionVariableNotAssign(\PhpParser\Node $node) : bool
    {
        if ($node !== null) {
            $expressionVariable = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$expressionVariable instanceof \PhpParser\Node\Expr\Assign) {
                return \true;
            }
        }
        return \false;
    }
}
