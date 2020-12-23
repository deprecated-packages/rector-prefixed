<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\PropertyManipulator;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a2ac50786fa\Rector\DeadCode\NodeManipulator\LivingCodeManipulator;
use _PhpScoper0a2ac50786fa\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScoper0a2ac50786fa\Rector\NodeRemoval\AssignRemover;
use _PhpScoper0a2ac50786fa\Rector\NodeRemoval\ClassMethodRemover;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\PostRector\Collector\NodesToRemoveCollector;
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
    public function autowireComplexRemovalTrait(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\PropertyManipulator $propertyManipulator, \_PhpScoper0a2ac50786fa\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector, \_PhpScoper0a2ac50786fa\Rector\DeadCode\NodeManipulator\LivingCodeManipulator $livingCodeManipulator, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper0a2ac50786fa\Rector\NodeRemoval\ClassMethodRemover $classMethodRemover, \_PhpScoper0a2ac50786fa\Rector\NodeRemoval\AssignRemover $assignRemover) : void
    {
        $this->parsedNodeCollector = $parsedNodeCollector;
        $this->propertyManipulator = $propertyManipulator;
        $this->livingCodeManipulator = $livingCodeManipulator;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->classMethodRemover = $classMethodRemover;
        $this->assignRemover = $assignRemover;
    }
    protected function removeClassMethodAndUsages(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->classMethodRemover->removeClassMethodAndUsages($classMethod);
    }
    /**
     * @param string[] $classMethodNamesToSkip
     */
    protected function removePropertyAndUsages(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $property, array $classMethodNamesToSkip = []) : void
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
    private function shouldSkipPropertyForClassMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr, array $classMethodNamesToSkip) : bool
    {
        /** @var ClassMethod|null $classMethodNode */
        $classMethodNode = $expr->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if ($classMethodNode === null) {
            return \false;
        }
        $classMethodName = $this->getName($classMethodNode);
        return \in_array($classMethodName, $classMethodNamesToSkip, \true);
    }
    /**
     * @param PropertyFetch|StaticPropertyFetch $expr
     */
    private function resolveAssign(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign
    {
        $assign = $expr->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        while ($assign !== null && !$assign instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
            $assign = $assign->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        if (!$assign instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException("Can't handle this situation");
        }
        return $assign;
    }
    private function removeConstructorDependency(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign $assign) : void
    {
        $methodName = $assign->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        if ($methodName !== \_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::CONSTRUCT) {
            return;
        }
        $class = $assign->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$class instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_) {
            return;
        }
        /** @var Class_|null $class */
        $constructClassMethod = $class->getMethod(\_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructClassMethod === null) {
            return;
        }
        $constructClassMethodStmts = $constructClassMethod->stmts;
        foreach ($constructClassMethod->getParams() as $param) {
            $variable = $this->betterNodeFinder->findFirst($constructClassMethodStmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use($param) : bool {
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
    private function isExpressionVariableNotAssign(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        if ($node !== null) {
            $expressionVariable = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$expressionVariable instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
                return \true;
            }
        }
        return \false;
    }
}
