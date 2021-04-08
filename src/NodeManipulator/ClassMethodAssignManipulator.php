<?php

declare (strict_types=1);
namespace Rector\Core\NodeManipulator;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\ClosureUse;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\List_;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Foreach_;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Reflection\ParametersAcceptor;
use PHPStan\Type\Type;
use Rector\Core\PhpParser\Comparing\NodeComparator;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\Core\PHPStan\Reflection\CallReflectionResolver;
use Rector\Core\Util\StaticNodeInstanceOf;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class ClassMethodAssignManipulator
{
    /**
     * @var VariableManipulator
     */
    private $variableManipulator;
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
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
     * @var NodeComparator
     */
    private $nodeComparator;
    /**
     * @var CallReflectionResolver
     */
    private $callReflectionResolver;
    /**
     * @var array<string, string[]>
     */
    private $alreadyAddedClassMethodNames = [];
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\Core\NodeManipulator\VariableManipulator $variableManipulator, \Rector\Core\PHPStan\Reflection\CallReflectionResolver $callReflectionResolver, \Rector\Core\PhpParser\Comparing\NodeComparator $nodeComparator)
    {
        $this->variableManipulator = $variableManipulator;
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeFactory = $nodeFactory;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->callReflectionResolver = $callReflectionResolver;
        $this->nodeComparator = $nodeComparator;
    }
    /**
     * @return Assign[]
     */
    public function collectReadyOnlyAssignScalarVariables(\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $assignsOfScalarOrArrayToVariable = $this->variableManipulator->collectScalarOrArrayAssignsOfVariable($classMethod);
        // filter out [$value] = $array, array destructing
        $readOnlyVariableAssigns = $this->filterOutArrayDestructedVariables($assignsOfScalarOrArrayToVariable, $classMethod);
        $readOnlyVariableAssigns = $this->filterOutReferencedVariables($readOnlyVariableAssigns, $classMethod);
        $readOnlyVariableAssigns = $this->filterOutMultiAssigns($readOnlyVariableAssigns);
        $readOnlyVariableAssigns = $this->filterOutForeachVariables($readOnlyVariableAssigns);
        return $this->variableManipulator->filterOutChangedVariables($readOnlyVariableAssigns, $classMethod);
    }
    public function addParameterAndAssignToMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod, string $name, ?\PHPStan\Type\Type $type, \PhpParser\Node\Expr\Assign $assign) : void
    {
        if ($this->hasMethodParameter($classMethod, $name)) {
            return;
        }
        $classMethod->params[] = $this->nodeFactory->createParamFromNameAndType($name, $type);
        $classMethod->stmts[] = new \PhpParser\Node\Stmt\Expression($assign);
        $classMethodHash = \spl_object_hash($classMethod);
        $this->alreadyAddedClassMethodNames[$classMethodHash][] = $name;
    }
    /**
     * @param Assign[] $variableAssigns
     * @return Assign[]
     */
    private function filterOutArrayDestructedVariables(array $variableAssigns, \PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $arrayDestructionCreatedVariables = [];
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($classMethod, function (\PhpParser\Node $node) use(&$arrayDestructionCreatedVariables) {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$node->var instanceof \PhpParser\Node\Expr\Array_ && !$node->var instanceof \PhpParser\Node\Expr\List_) {
                return null;
            }
            foreach ($node->var->items as $arrayItem) {
                // empty item
                if ($arrayItem === null) {
                    continue;
                }
                if (!$arrayItem->value instanceof \PhpParser\Node\Expr\Variable) {
                    continue;
                }
                /** @var string $variableName */
                $variableName = $this->nodeNameResolver->getName($arrayItem->value);
                $arrayDestructionCreatedVariables[] = $variableName;
            }
        });
        return \array_filter($variableAssigns, function (\PhpParser\Node\Expr\Assign $assign) use($arrayDestructionCreatedVariables) : bool {
            return !$this->nodeNameResolver->isNames($assign->var, $arrayDestructionCreatedVariables);
        });
    }
    /**
     * @param Assign[] $variableAssigns
     * @return Assign[]
     */
    private function filterOutReferencedVariables(array $variableAssigns, \PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $referencedVariables = $this->collectReferenceVariableNames($classMethod);
        return \array_filter($variableAssigns, function (\PhpParser\Node\Expr\Assign $assign) use($referencedVariables) : bool {
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
        return \array_filter($readOnlyVariableAssigns, function (\PhpParser\Node\Expr\Assign $assign) : bool {
            $parent = $assign->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            return !$parent instanceof \PhpParser\Node\Expr\Assign;
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
            if (!$foreach instanceof \PhpParser\Node\Stmt\Foreach_) {
                continue;
            }
            if ($this->nodeComparator->areNodesEqual($foreach->valueVar, $variableAssign->var)) {
                unset($variableAssigns[$key]);
                continue;
            }
            if ($this->nodeComparator->areNodesEqual($foreach->keyVar, $variableAssign->var)) {
                unset($variableAssigns[$key]);
            }
        }
        return $variableAssigns;
    }
    private function hasMethodParameter(\PhpParser\Node\Stmt\ClassMethod $classMethod, string $name) : bool
    {
        foreach ($classMethod->params as $param) {
            if ($this->nodeNameResolver->isName($param->var, $name)) {
                return \true;
            }
        }
        $classMethodHash = \spl_object_hash($classMethod);
        if (!isset($this->alreadyAddedClassMethodNames[$classMethodHash])) {
            return \false;
        }
        return \in_array($name, $this->alreadyAddedClassMethodNames[$classMethodHash], \true);
    }
    /**
     * @return string[]
     */
    private function collectReferenceVariableNames(\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $referencedVariables = [];
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($classMethod, function (\PhpParser\Node $node) use(&$referencedVariables) {
            if (!$node instanceof \PhpParser\Node\Expr\Variable) {
                return null;
            }
            if ($this->nodeNameResolver->isName($node, 'this')) {
                return null;
            }
            $parentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode !== null && $this->isExplicitlyReferenced($parentNode)) {
                /** @var string $variableName */
                $variableName = $this->nodeNameResolver->getName($node);
                $referencedVariables[] = $variableName;
                return null;
            }
            $argumentPosition = null;
            if ($parentNode instanceof \PhpParser\Node\Arg) {
                $argumentPosition = $parentNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ARGUMENT_POSITION);
                $parentNode = $parentNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            }
            if (!$parentNode instanceof \PhpParser\Node) {
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
    private function findParentForeach(\PhpParser\Node\Expr\Assign $assign) : ?\PhpParser\Node\Stmt\Foreach_
    {
        /** @var Foreach_|FunctionLike|null $foundNode */
        $foundNode = $this->betterNodeFinder->findFirstPreviousOfTypes($assign, [\PhpParser\Node\Stmt\Foreach_::class, \PhpParser\Node\FunctionLike::class]);
        if (!$foundNode instanceof \PhpParser\Node\Stmt\Foreach_) {
            return null;
        }
        return $foundNode;
    }
    private function isExplicitlyReferenced(\PhpParser\Node $node) : bool
    {
        if (!\property_exists($node, 'byRef')) {
            return \false;
        }
        if (\Rector\Core\Util\StaticNodeInstanceOf::isOneOf($node, [\PhpParser\Node\Arg::class, \PhpParser\Node\Expr\ClosureUse::class, \PhpParser\Node\Param::class])) {
            return $node->byRef;
        }
        return \false;
    }
    private function isCallOrConstructorWithReference(\PhpParser\Node $node, \PhpParser\Node\Expr\Variable $variable, int $argumentPosition) : bool
    {
        if ($this->isMethodCallWithReferencedArgument($node, $variable)) {
            return \true;
        }
        if ($this->isFuncCallWithReferencedArgument($node, $variable)) {
            return \true;
        }
        return $this->isConstructorWithReference($node, $argumentPosition);
    }
    private function isMethodCallWithReferencedArgument(\PhpParser\Node $node, \PhpParser\Node\Expr\Variable $variable) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        $methodReflection = $this->callReflectionResolver->resolveCall($node);
        if (!$methodReflection instanceof \PHPStan\Reflection\MethodReflection) {
            return \false;
        }
        $variableName = $this->nodeNameResolver->getName($variable);
        $parametersAcceptor = $this->callReflectionResolver->resolveParametersAcceptor($methodReflection, $node);
        if (!$parametersAcceptor instanceof \PHPStan\Reflection\ParametersAcceptor) {
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
    private function isFuncCallWithReferencedArgument(\PhpParser\Node $node, \PhpParser\Node\Expr\Variable $variable) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isNames($node, ['array_shift', '*sort'])) {
            return \false;
        }
        // is 1t argument
        return $node->args[0]->value !== $variable;
    }
    private function isConstructorWithReference(\PhpParser\Node $node, int $argumentPosition) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\New_) {
            return \false;
        }
        return $this->isParameterReferencedInMethodReflection($node, $argumentPosition);
    }
    private function isParameterReferencedInMethodReflection(\PhpParser\Node\Expr\New_ $new, int $argumentPosition) : bool
    {
        $methodReflection = $this->callReflectionResolver->resolveConstructor($new);
        $parametersAcceptor = $this->callReflectionResolver->resolveParametersAcceptor($methodReflection, $new);
        if (!$parametersAcceptor instanceof \PHPStan\Reflection\ParametersAcceptor) {
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
