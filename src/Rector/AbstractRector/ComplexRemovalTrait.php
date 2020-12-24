<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\PropertyManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\DeadCode\NodeManipulator\LivingCodeManipulator;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScoperb75b35f52b74\Rector\NodeRemoval\AssignRemover;
use _PhpScoperb75b35f52b74\Rector\NodeRemoval\ClassMethodRemover;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PostRector\Collector\NodesToRemoveCollector;
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
    public function autowireComplexRemovalTrait(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\PropertyManipulator $propertyManipulator, \_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector, \_PhpScoperb75b35f52b74\Rector\DeadCode\NodeManipulator\LivingCodeManipulator $livingCodeManipulator, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoperb75b35f52b74\Rector\NodeRemoval\ClassMethodRemover $classMethodRemover, \_PhpScoperb75b35f52b74\Rector\NodeRemoval\AssignRemover $assignRemover) : void
    {
        $this->parsedNodeCollector = $parsedNodeCollector;
        $this->propertyManipulator = $propertyManipulator;
        $this->livingCodeManipulator = $livingCodeManipulator;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->classMethodRemover = $classMethodRemover;
        $this->assignRemover = $assignRemover;
    }
    protected function removeClassMethodAndUsages(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->classMethodRemover->removeClassMethodAndUsages($classMethod);
    }
    /**
     * @param string[] $classMethodNamesToSkip
     */
    protected function removePropertyAndUsages(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property, array $classMethodNamesToSkip = []) : void
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
    private function shouldSkipPropertyForClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr, array $classMethodNamesToSkip) : bool
    {
        /** @var ClassMethod|null $classMethodNode */
        $classMethodNode = $expr->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if ($classMethodNode === null) {
            return \false;
        }
        $classMethodName = $this->getName($classMethodNode);
        return \in_array($classMethodName, $classMethodNamesToSkip, \true);
    }
    /**
     * @param PropertyFetch|StaticPropertyFetch $expr
     */
    private function resolveAssign(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign
    {
        $assign = $expr->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        while ($assign !== null && !$assign instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            $assign = $assign->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        if (!$assign instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException("Can't handle this situation");
        }
        return $assign;
    }
    private function removeConstructorDependency(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) : void
    {
        $methodName = $assign->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        if ($methodName !== \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT) {
            return;
        }
        $class = $assign->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return;
        }
        /** @var Class_|null $class */
        $constructClassMethod = $class->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructClassMethod === null) {
            return;
        }
        $constructClassMethodStmts = $constructClassMethod->stmts;
        foreach ($constructClassMethod->getParams() as $param) {
            $variable = $this->betterNodeFinder->findFirst($constructClassMethodStmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($param) : bool {
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
    private function isExpressionVariableNotAssign(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        if ($node !== null) {
            $expressionVariable = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$expressionVariable instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
                return \true;
            }
        }
        return \false;
    }
}
