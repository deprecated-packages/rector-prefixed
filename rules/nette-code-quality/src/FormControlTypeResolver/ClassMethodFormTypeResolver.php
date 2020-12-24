<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\FormControlTypeResolver;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName;
use _PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
final class ClassMethodFormTypeResolver implements \_PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface, \_PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var MethodNamesByInputNamesResolver
     */
    private $methodNamesByInputNamesResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod) {
            return [];
        }
        if ($this->nodeNameResolver->isName($node, \_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return [];
        }
        /** @var Return_|null $lastReturn */
        $lastReturn = $this->betterNodeFinder->findLastInstanceOf((array) $node->stmts, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_::class);
        if ($lastReturn === null) {
            return [];
        }
        if (!$lastReturn->expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
            return [];
        }
        return $this->methodNamesByInputNamesResolver->resolveExpr($lastReturn->expr);
    }
    public function setResolver(\_PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver) : void
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }
}
