<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClosureUse;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\List_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ObjectTypeMethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParameterReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper0a2ac50786fa\Rector\Core\PHPStan\Reflection\CallReflectionResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\VariableManipulator $variableManipulator, \_PhpScoper0a2ac50786fa\Rector\Core\PHPStan\Reflection\CallReflectionResolver $callReflectionResolver)
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
    public function collectReadyOnlyAssignScalarVariables(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $assignsOfScalarOrArrayToVariable = $this->variableManipulator->collectScalarOrArrayAssignsOfVariable($classMethod);
        // filter out [$value] = $array, array destructing
        $readOnlyVariableAssigns = $this->filterOutArrayDestructedVariables($assignsOfScalarOrArrayToVariable, $classMethod);
        $readOnlyVariableAssigns = $this->filterOutReferencedVariables($readOnlyVariableAssigns, $classMethod);
        $readOnlyVariableAssigns = $this->filterOutMultiAssigns($readOnlyVariableAssigns);
        $readOnlyVariableAssigns = $this->filterOutForeachVariables($readOnlyVariableAssigns);
        return $this->variableManipulator->filterOutChangedVariables($readOnlyVariableAssigns, $classMethod);
    }
    public function addParameterAndAssignToMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, string $name, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign $assign) : void
    {
        if ($this->hasMethodParameter($classMethod, $name)) {
            return;
        }
        $classMethod->params[] = $this->nodeFactory->createParamFromNameAndType($name, $type);
        $classMethod->stmts[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression($assign);
    }
    /**
     * @param Assign[] $variableAssigns
     * @return Assign[]
     */
    private function filterOutArrayDestructedVariables(array $variableAssigns, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $arrayDestructionCreatedVariables = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($classMethod, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use(&$arrayDestructionCreatedVariables) {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$node->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_ && !$node->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\List_) {
                return null;
            }
            foreach ($node->var->items as $arrayItem) {
                // empty item
                if ($arrayItem === null) {
                    continue;
                }
                if (!$arrayItem->value instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
                    continue;
                }
                /** @var string $variableName */
                $variableName = $this->nodeNameResolver->getName($arrayItem->value);
                $arrayDestructionCreatedVariables[] = $variableName;
            }
        });
        return \array_filter($variableAssigns, function (\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign $assign) use($arrayDestructionCreatedVariables) : bool {
            return !$this->nodeNameResolver->isNames($assign->var, $arrayDestructionCreatedVariables);
        });
    }
    /**
     * @param Assign[] $variableAssigns
     * @return Assign[]
     */
    private function filterOutReferencedVariables(array $variableAssigns, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $referencedVariables = $this->collectReferenceVariableNames($classMethod);
        return \array_filter($variableAssigns, function (\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign $assign) use($referencedVariables) : bool {
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
        return \array_filter($readOnlyVariableAssigns, function (\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign $assign) : bool {
            $parentNode = $assign->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            return !$parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
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
            if (!$foreach instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_) {
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
    private function hasMethodParameter(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, string $name) : bool
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
    private function collectReferenceVariableNames(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $referencedVariables = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($classMethod, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use(&$referencedVariables) {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
                return null;
            }
            if ($this->nodeNameResolver->isName($node, 'this')) {
                return null;
            }
            $parentNode = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode !== null && $this->isExplicitlyReferenced($parentNode)) {
                /** @var string $variableName */
                $variableName = $this->nodeNameResolver->getName($node);
                $referencedVariables[] = $variableName;
                return null;
            }
            $argumentPosition = null;
            if ($parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg) {
                $argumentPosition = $parentNode->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::ARGUMENT_POSITION);
                $parentNode = $parentNode->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            }
            if (!$parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node) {
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
    private function findParentForeach(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign $assign) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_
    {
        /** @var Foreach_|FunctionLike|null $foreach */
        $foreach = $this->betterNodeFinder->findFirstPreviousOfTypes($assign, [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike::class]);
        if (!$foreach instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_) {
            return null;
        }
        return $foreach;
    }
    private function isExplicitlyReferenced(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg || $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClosureUse || $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Param) {
            return $node->byRef;
        }
        return \false;
    }
    private function isCallOrConstructorWithReference(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $variable, int $argumentPosition) : bool
    {
        if ($this->isMethodCallWithReferencedArgument($node, $variable)) {
            return \true;
        }
        if ($this->isFuncCallWithReferencedArgument($node, $variable)) {
            return \true;
        }
        return $this->isConstructorWithReference($node, $argumentPosition);
    }
    private function isMethodCallWithReferencedArgument(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $variable) : bool
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        $methodReflection = $this->callReflectionResolver->resolveCall($node);
        if (!$methodReflection instanceof \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ObjectTypeMethodReflection) {
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
    private function isFuncCallWithReferencedArgument(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $variable) : bool
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isNames($node, ['array_shift', '*sort'])) {
            return \false;
        }
        // is 1t argument
        return $node->args[0]->value !== $variable;
    }
    private function isConstructorWithReference(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, int $argumentPosition) : bool
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_) {
            return \false;
        }
        return $this->isParameterReferencedInMethodReflection($node, $argumentPosition);
    }
    private function isParameterReferencedInMethodReflection(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_ $new, int $argumentPosition) : bool
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
