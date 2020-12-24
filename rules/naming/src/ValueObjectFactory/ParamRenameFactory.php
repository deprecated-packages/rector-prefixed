<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\ValueObjectFactory;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrowFunction;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure;
use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a6b37af0871\Rector\Naming\Contract\ExpectedNameResolver\ExpectedNameResolverInterface;
use _PhpScoper0a6b37af0871\Rector\Naming\ValueObject\ParamRename;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function create(\_PhpScoper0a6b37af0871\PhpParser\Node\Param $param, \_PhpScoper0a6b37af0871\Rector\Naming\Contract\ExpectedNameResolver\ExpectedNameResolverInterface $expectedNameResolver) : ?\_PhpScoper0a6b37af0871\Rector\Naming\ValueObject\ParamRename
    {
        $expectedName = $expectedNameResolver->resolveIfNotYet($param);
        if ($expectedName === null) {
            return null;
        }
        /** @var ClassMethod|Function_|Closure|ArrowFunction|null $functionLike */
        $functionLike = $this->betterNodeFinder->findFirstParentInstanceOf($param, \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike::class);
        if ($functionLike === null) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException("There shouldn't be a param outside of FunctionLike");
        }
        if ($functionLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrowFunction) {
            return null;
        }
        $currentName = $this->nodeNameResolver->getName($param->var);
        if ($currentName === null) {
            return null;
        }
        return new \_PhpScoper0a6b37af0871\Rector\Naming\ValueObject\ParamRename($currentName, $expectedName, $param, $param->var, $functionLike);
    }
}
