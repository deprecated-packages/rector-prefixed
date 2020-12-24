<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\Encapsed;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\SOLID\Guard\VariableToConstantGuard;
final class VariableManipulator
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var AssignManipulator
     */
    private $assignManipulator;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var ArrayManipulator
     */
    private $arrayManipulator;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var VariableToConstantGuard
     */
    private $variableToConstantGuard;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ArrayManipulator $arrayManipulator, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\AssignManipulator $assignManipulator, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\SOLID\Guard\VariableToConstantGuard $variableToConstantGuard)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->assignManipulator = $assignManipulator;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->arrayManipulator = $arrayManipulator;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->variableToConstantGuard = $variableToConstantGuard;
    }
    /**
     * @return Assign[]
     */
    public function collectScalarOrArrayAssignsOfVariable(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $assignsOfArrayToVariable = [];
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->getStmts(), function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use(&$assignsOfArrayToVariable) {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
                return null;
            }
            if (!$node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_ && !$node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar) {
                return null;
            }
            if ($node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\Encapsed) {
                return null;
            }
            if ($node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_ && !$this->arrayManipulator->isArrayOnlyScalarValues($node->expr)) {
                return null;
            }
            if ($this->isTestCaseExpectedVariable($node->var)) {
                return null;
            }
            $assignsOfArrayToVariable[] = $node;
        });
        return $assignsOfArrayToVariable;
    }
    /**
     * @param Assign[] $assignsOfArrayToVariable
     * @return Assign[]
     */
    public function filterOutChangedVariables(array $assignsOfArrayToVariable, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        return \array_filter($assignsOfArrayToVariable, function (\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) use($classMethod) : bool {
            /** @var Variable $variable */
            $variable = $assign->var;
            return $this->isReadOnlyVariable($classMethod, $variable, $assign);
        });
    }
    private function isTestCaseExpectedVariable(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable) : bool
    {
        /** @var string $className */
        $className = $variable->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if (!\_PhpScoperb75b35f52b74\Nette\Utils\Strings::endsWith($className, 'Test')) {
            return \false;
        }
        return $this->nodeNameResolver->isName($variable, 'expect*');
    }
    /**
     * Inspiration
     * @see \Rector\Core\PhpParser\Node\Manipulator\PropertyManipulator::isReadOnlyProperty()
     */
    private function isReadOnlyVariable(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) : bool
    {
        $variableUsages = $this->collectVariableUsages($classMethod, $variable, $assign);
        foreach ($variableUsages as $variableUsage) {
            $parent = $variableUsage->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Arg && !$this->variableToConstantGuard->isReadArg($parent)) {
                return \false;
            }
            if (!$this->assignManipulator->isLeftPartOfAssign($variableUsage)) {
                continue;
            }
            return \false;
        }
        return \true;
    }
    /**
     * @return Variable[]
     */
    private function collectVariableUsages(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) : array
    {
        return $this->betterNodeFinder->find((array) $classMethod->getStmts(), function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($variable, $assign) : bool {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
                return \false;
            }
            // skip initialization
            $parentNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode === $assign) {
                return \false;
            }
            return $this->betterStandardPrinter->areNodesEqual($node, $variable);
        });
    }
}
