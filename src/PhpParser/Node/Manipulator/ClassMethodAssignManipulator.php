<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClosureUse;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\List_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_;
use _PhpScopere8e811afab72\PHPStan\Reflection\ObjectTypeMethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflection;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\Core\PHPStan\Reflection\CallReflectionResolver;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class ClassMethodAssignManipulator
{
    /**
     * @var VariableManipulator
     */
    private $variableManipulator;
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var CallReflectionResolver
     */
    private $callReflectionResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\VariableManipulator $variableManipulator, \_PhpScopere8e811afab72\Rector\Core\PHPStan\Reflection\CallReflectionResolver $callReflectionResolver)
    {
        $this->variableManipulator = $variableManipulator;
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeFactory = $nodeFactory;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->callReflectionResolver = $callReflectionResolver;
    }
    /**
     * @return Assign[]
     */
    public function collectReadyOnlyAssignScalarVariables(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $assignsOfScalarOrArrayToVariable = $this->variableManipulator->collectScalarOrArrayAssignsOfVariable($classMethod);
        // filter out [$value] = $array, array destructing
        $readOnlyVariableAssigns = $this->filterOutArrayDestructedVariables($assignsOfScalarOrArrayToVariable, $classMethod);
        $readOnlyVariableAssigns = $this->filterOutReferencedVariables($readOnlyVariableAssigns, $classMethod);
        $readOnlyVariableAssigns = $this->filterOutMultiAssigns($readOnlyVariableAssigns);
        $readOnlyVariableAssigns = $this->filterOutForeachVariables($readOnlyVariableAssigns);
        return $this->variableManipulator->filterOutChangedVariables($readOnlyVariableAssigns, $classMethod);
    }
    public function addParameterAndAssignToMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, string $name, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $type, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign) : void
    {
        if ($this->hasMethodParameter($classMethod, $name)) {
            return;
        }
        $classMethod->params[] = $this->nodeFactory->createParamFromNameAndType($name, $type);
        $classMethod->stmts[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($assign);
    }
    /**
     * @param Assign[] $variableAssigns
     * @return Assign[]
     */
    private function filterOutArrayDestructedVariables(array $variableAssigns, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $arrayDestructionCreatedVariables = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($classMethod, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use(&$arrayDestructionCreatedVariables) {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_ && !$node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\List_) {
                return null;
            }
            foreach ($node->var->items as $arrayItem) {
                // empty item
                if ($arrayItem === null) {
                    continue;
                }
                if (!$arrayItem->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
                    continue;
                }
                /** @var string $variableName */
                $variableName = $this->nodeNameResolver->getName($arrayItem->value);
                $arrayDestructionCreatedVariables[] = $variableName;
            }
        });
        return \array_filter($variableAssigns, function (\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign) use($arrayDestructionCreatedVariables) : bool {
            return !$this->nodeNameResolver->isNames($assign->var, $arrayDestructionCreatedVariables);
        });
    }
    /**
     * @param Assign[] $variableAssigns
     * @return Assign[]
     */
    private function filterOutReferencedVariables(array $variableAssigns, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $referencedVariables = $this->collectReferenceVariableNames($classMethod);
        return \array_filter($variableAssigns, function (\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign) use($referencedVariables) : bool {
            return !$this->nodeNameResolver->isNames($assign->var, $referencedVariables);
        });
    }
    /**
     * E.g. $a = $b = $c = '...';
     *
     * @param Assign[] $readOnlyVariableAssigns
     * @return Assign[]
     */
    private function filterOutMultiAssigns(array $readOnlyVariableAssigns) : array
    {
        return \array_filter($readOnlyVariableAssigns, function (\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign) : bool {
            $parentNode = $assign->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            return !$parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
        });
    }
    /**
     * @param Assign[] $variableAssigns
     * @return Assign[]
     */
    private function filterOutForeachVariables(array $variableAssigns) : array
    {
        foreach ($variableAssigns as $key => $variableAssign) {
            $foreach = $this->findParentForeach($variableAssign);
            if (!$foreach instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_) {
                continue;
            }
            if ($this->betterStandardPrinter->areNodesEqual($foreach->valueVar, $variableAssign->var)) {
                unset($variableAssigns[$key]);
                continue;
            }
            if ($this->betterStandardPrinter->areNodesEqual($foreach->keyVar, $variableAssign->var)) {
                unset($variableAssigns[$key]);
            }
        }
        return $variableAssigns;
    }
    private function hasMethodParameter(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, string $name) : bool
    {
        foreach ($classMethod->params as $constructorParameter) {
            if ($this->nodeNameResolver->isName($constructorParameter->var, $name)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @return string[]
     */
    private function collectReferenceVariableNames(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $referencedVariables = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($classMethod, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use(&$referencedVariables) {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
                return null;
            }
            if ($this->nodeNameResolver->isName($node, 'this')) {
                return null;
            }
            $parentNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode !== null && $this->isExplicitlyReferenced($parentNode)) {
                /** @var string $variableName */
                $variableName = $this->nodeNameResolver->getName($node);
                $referencedVariables[] = $variableName;
                return null;
            }
            $argumentPosition = null;
            if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Arg) {
                $argumentPosition = $parentNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::ARGUMENT_POSITION);
                $parentNode = $parentNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            }
            if (!$parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node) {
                return null;
            }
            if ($argumentPosition === null) {
                return null;
            }
            /** @var string $variableName */
            $variableName = $this->nodeNameResolver->getName($node);
            if ($this->isCallOrConstructorWithReference($parentNode, $node, $argumentPosition)) {
                $referencedVariables[] = $variableName;
            }
        });
        return $referencedVariables;
    }
    private function findParentForeach(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_
    {
        /** @var Foreach_|FunctionLike|null $foreach */
        $foreach = $this->betterNodeFinder->findFirstPreviousOfTypes($assign, [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_::class, \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike::class]);
        if (!$foreach instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_) {
            return null;
        }
        return $foreach;
    }
    private function isExplicitlyReferenced(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Arg || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClosureUse || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Param) {
            return $node->byRef;
        }
        return \false;
    }
    private function isCallOrConstructorWithReference(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable, int $argumentPosition) : bool
    {
        if ($this->isMethodCallWithReferencedArgument($node, $variable)) {
            return \true;
        }
        if ($this->isFuncCallWithReferencedArgument($node, $variable)) {
            return \true;
        }
        return $this->isConstructorWithReference($node, $argumentPosition);
    }
    private function isMethodCallWithReferencedArgument(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        $methodReflection = $this->callReflectionResolver->resolveCall($node);
        if (!$methodReflection instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\ObjectTypeMethodReflection) {
            return \false;
        }
        $variableName = $this->nodeNameResolver->getName($variable);
        $parametersAcceptor = $this->callReflectionResolver->resolveParametersAcceptor($methodReflection, $node);
        if ($parametersAcceptor === null) {
            return \false;
        }
        /** @var ParameterReflection $parameterReflection */
        foreach ($parametersAcceptor->getParameters() as $parameterReflection) {
            if ($parameterReflection->getName() !== $variableName) {
                continue;
            }
            return $parameterReflection->passedByReference()->yes();
        }
        return \false;
    }
    /**
     * Matches e.g:
     * - array_shift($value)
     * - sort($values)
     */
    private function isFuncCallWithReferencedArgument(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isNames($node, ['array_shift', '*sort'])) {
            return \false;
        }
        // is 1t argument
        return $node->args[0]->value !== $variable;
    }
    private function isConstructorWithReference(\_PhpScopere8e811afab72\PhpParser\Node $node, int $argumentPosition) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_) {
            return \false;
        }
        return $this->isParameterReferencedInMethodReflection($node, $argumentPosition);
    }
    private function isParameterReferencedInMethodReflection(\_PhpScopere8e811afab72\PhpParser\Node\Expr\New_ $new, int $argumentPosition) : bool
    {
        $methodReflection = $this->callReflectionResolver->resolveConstructor($new);
        $parametersAcceptor = $this->callReflectionResolver->resolveParametersAcceptor($methodReflection, $new);
        if ($parametersAcceptor === null) {
            return \false;
        }
        /** @var ParameterReflection $parameterReflection */
        foreach ($parametersAcceptor->getParameters() as $parameterPosition => $parameterReflection) {
            if ($parameterPosition !== $argumentPosition) {
                continue;
            }
            return $parameterReflection->passedByReference()->yes();
        }
        return \false;
    }
}
