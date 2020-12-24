<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\ValueObjectFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrowFunction;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\Naming\Contract\ExpectedNameResolver\ExpectedNameResolverInterface;
use _PhpScopere8e811afab72\Rector\Naming\ValueObject\ParamRename;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
final class ParamRenameFactory
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function create(\_PhpScopere8e811afab72\PhpParser\Node\Param $param, \_PhpScopere8e811afab72\Rector\Naming\Contract\ExpectedNameResolver\ExpectedNameResolverInterface $expectedNameResolver) : ?\_PhpScopere8e811afab72\Rector\Naming\ValueObject\ParamRename
    {
        $expectedName = $expectedNameResolver->resolveIfNotYet($param);
        if ($expectedName === null) {
            return null;
        }
        /** @var ClassMethod|Function_|Closure|ArrowFunction|null $functionLike */
        $functionLike = $this->betterNodeFinder->findFirstParentInstanceOf($param, \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike::class);
        if ($functionLike === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException("There shouldn't be a param outside of FunctionLike");
        }
        if ($functionLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrowFunction) {
            return null;
        }
        $currentName = $this->nodeNameResolver->getName($param->var);
        if ($currentName === null) {
            return null;
        }
        return new \_PhpScopere8e811afab72\Rector\Naming\ValueObject\ParamRename($currentName, $expectedName, $param, $param->var, $functionLike);
    }
}
