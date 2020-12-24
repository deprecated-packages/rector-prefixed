<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Naming;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\Naming\PhpArray\ArrayFilter;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
final class ConflictingNameResolver
{
    /**
     * @var string[][]
     */
    private $conflictingVariableNamesByClassMethod = [];
    /**
     * @var ExpectedNameResolver
     */
    private $expectedNameResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var ArrayFilter
     */
    private $arrayFilter;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Naming\PhpArray\ArrayFilter $arrayFilter, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoperb75b35f52b74\Rector\Naming\Naming\ExpectedNameResolver $expectedNameResolver, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->expectedNameResolver = $expectedNameResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->arrayFilter = $arrayFilter;
    }
    /**
     * @return string[]
     */
    public function resolveConflictingVariableNamesForParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $expectedNames = [];
        foreach ($classMethod->params as $param) {
            $expectedName = $this->expectedNameResolver->resolveForParam($param);
            if ($expectedName === null) {
                continue;
            }
            $expectedNames[] = $expectedName;
        }
        return $this->arrayFilter->filterWithAtLeastTwoOccurences($expectedNames);
    }
    /**
     * @param ClassMethod|Function_|Closure $functionLike
     */
    public function checkNameIsInFunctionLike(string $variableName, \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : bool
    {
        $conflictingVariableNames = $this->resolveConflictingVariableNamesForNew($functionLike);
        return \in_array($variableName, $conflictingVariableNames, \true);
    }
    /**
     * @param ClassMethod|Function_|Closure $functionLike
     * @return string[]
     */
    private function resolveConflictingVariableNamesForNew(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : array
    {
        // cache it!
        $classMethodHash = \spl_object_hash($functionLike);
        if (isset($this->conflictingVariableNamesByClassMethod[$classMethodHash])) {
            return $this->conflictingVariableNamesByClassMethod[$classMethodHash];
        }
        $paramNames = $this->collectParamNames($functionLike);
        $newAssignNames = $this->resolveForNewAssigns($functionLike);
        $nonNewAssignNames = $this->resolveForNonNewAssigns($functionLike);
        $protectedNames = \array_merge($paramNames, $newAssignNames, $nonNewAssignNames);
        $protectedNames = $this->arrayFilter->filterWithAtLeastTwoOccurences($protectedNames);
        $this->conflictingVariableNamesByClassMethod[$classMethodHash] = $protectedNames;
        return $protectedNames;
    }
    /**
     * @param ClassMethod|Function_|Closure $functionLike
     * @return string[]
     */
    private function collectParamNames(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : array
    {
        $paramNames = [];
        // params
        foreach ($functionLike->params as $param) {
            $paramNames[] = $this->nodeNameResolver->getName($param);
        }
        return $paramNames;
    }
    /**
     * @param ClassMethod|Function_|Closure $functionLike
     * @return string[]
     */
    private function resolveForNewAssigns(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : array
    {
        $names = [];
        /** @var Assign[] $assigns */
        $assigns = $this->betterNodeFinder->findInstanceOf((array) $functionLike->stmts, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign::class);
        foreach ($assigns as $assign) {
            $name = $this->expectedNameResolver->resolveForAssignNew($assign);
            if ($name === null) {
                continue;
            }
            $names[] = $name;
        }
        return $names;
    }
    /**
     * @param ClassMethod|Function_|Closure $functionLike
     * @return string[]
     */
    private function resolveForNonNewAssigns(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : array
    {
        $names = [];
        /** @var Assign[] $assigns */
        $assigns = $this->betterNodeFinder->findInstanceOf((array) $functionLike->stmts, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign::class);
        foreach ($assigns as $assign) {
            $name = $this->expectedNameResolver->resolveForAssignNonNew($assign);
            if ($name === null) {
                continue;
            }
            $names[] = $name;
        }
        return $names;
    }
}
