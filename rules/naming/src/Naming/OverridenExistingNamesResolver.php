<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\Naming;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Closure;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a2ac50786fa\Rector\Naming\PhpArray\ArrayFilter;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
final class OverridenExistingNamesResolver
{
    /**
     * @var array<string, array<int, string>>
     */
    private $overridenExistingVariableNamesByClassMethod = [];
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Naming\PhpArray\ArrayFilter $arrayFilter, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->arrayFilter = $arrayFilter;
    }
    /**
     * @param ClassMethod|Function_|Closure $functionLike
     */
    public function checkNameInClassMethodForNew(string $variableName, \_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike $functionLike) : bool
    {
        $overridenVariableNames = $this->resolveOveriddenNamesForNew($functionLike);
        return \in_array($variableName, $overridenVariableNames, \true);
    }
    public function checkNameInClassMethodForParam(string $expectedName, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var Assign[] $assigns */
        $assigns = $this->betterNodeFinder->findInstanceOf((array) $classMethod->stmts, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign::class);
        $usedVariableNames = [];
        foreach ($assigns as $assign) {
            if (!$assign->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
                continue;
            }
            $variableName = $this->nodeNameResolver->getName($assign->var);
            if ($variableName === null) {
                continue;
            }
            $usedVariableNames[] = $variableName;
        }
        return \in_array($expectedName, $usedVariableNames, \true);
    }
    /**
     * @param ClassMethod|Function_|Closure $functionLike
     * @return string[]
     */
    private function resolveOveriddenNamesForNew(\_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike $functionLike) : array
    {
        $classMethodHash = \spl_object_hash($functionLike);
        if (isset($this->overridenExistingVariableNamesByClassMethod[$classMethodHash])) {
            return $this->overridenExistingVariableNamesByClassMethod[$classMethodHash];
        }
        $currentlyUsedNames = [];
        /** @var Assign[] $assigns */
        $assigns = $this->betterNodeFinder->findInstanceOf((array) $functionLike->stmts, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign::class);
        foreach ($assigns as $assign) {
            /** @var Variable $assignVariable */
            $assignVariable = $assign->var;
            $currentVariableName = $this->nodeNameResolver->getName($assignVariable);
            if ($currentVariableName === null) {
                continue;
            }
            $currentlyUsedNames[] = $currentVariableName;
        }
        $currentlyUsedNames = \array_values($currentlyUsedNames);
        $currentlyUsedNames = $this->arrayFilter->filterWithAtLeastTwoOccurences($currentlyUsedNames);
        $this->overridenExistingVariableNamesByClassMethod[$classMethodHash] = $currentlyUsedNames;
        return $currentlyUsedNames;
    }
}
