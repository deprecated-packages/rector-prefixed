<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\ValueObjectFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrowFunction;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\Naming\Contract\ExpectedNameResolver\ExpectedNameResolverInterface;
use _PhpScoperb75b35f52b74\Rector\Naming\ValueObject\ParamRename;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function create(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param, \_PhpScoperb75b35f52b74\Rector\Naming\Contract\ExpectedNameResolver\ExpectedNameResolverInterface $expectedNameResolver) : ?\_PhpScoperb75b35f52b74\Rector\Naming\ValueObject\ParamRename
    {
        $expectedName = $expectedNameResolver->resolveIfNotYet($param);
        if ($expectedName === null) {
            return null;
        }
        /** @var ClassMethod|Function_|Closure|ArrowFunction|null $functionLike */
        $functionLike = $this->betterNodeFinder->findFirstParentInstanceOf($param, \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike::class);
        if ($functionLike === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException("There shouldn't be a param outside of FunctionLike");
        }
        if ($functionLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrowFunction) {
            return null;
        }
        $currentName = $this->nodeNameResolver->getName($param->var);
        if ($currentName === null) {
            return null;
        }
        return new \_PhpScoperb75b35f52b74\Rector\Naming\ValueObject\ParamRename($currentName, $expectedName, $param, $param->var, $functionLike);
    }
}
