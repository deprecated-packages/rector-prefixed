<?php

declare(strict_types=1);

namespace Rector\Nette\FormControlTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\ValueObject\MethodName;
use Rector\Nette\Contract\FormControlTypeResolverInterface;
use Rector\Nette\Contract\MethodNamesByInputNamesResolverAwareInterface;
use Rector\Nette\NodeResolver\MethodNamesByInputNamesResolver;
use Rector\NodeNameResolver\NodeNameResolver;

final class ClassMethodFormTypeResolver implements FormControlTypeResolverInterface, MethodNamesByInputNamesResolverAwareInterface
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

    public function __construct(BetterNodeFinder $betterNodeFinder, NodeNameResolver $nodeNameResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }

    /**
     * @return array<string, string>
     */
    public function resolve(Node $node): array
    {
        if (! $node instanceof ClassMethod) {
            return [];
        }

        if ($this->nodeNameResolver->isName($node, MethodName::CONSTRUCT)) {
            return [];
        }

        $lastReturn = $this->betterNodeFinder->findLastInstanceOf((array) $node->stmts, Return_::class);
        if (! $lastReturn instanceof Return_) {
            return [];
        }

        if (! $lastReturn->expr instanceof Variable) {
            return [];
        }

        return $this->methodNamesByInputNamesResolver->resolveExpr($lastReturn->expr);
    }

    /**
     * @return void
     */
    public function setResolver(MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver)
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }
}
