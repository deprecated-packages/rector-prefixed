<?php

declare(strict_types=1);

namespace Rector\Nette\FormControlTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\ValueObject\MethodName;
use Rector\Nette\Contract\FormControlTypeResolverInterface;
use Rector\Nette\Contract\MethodNamesByInputNamesResolverAwareInterface;
use Rector\Nette\NodeResolver\MethodNamesByInputNamesResolver;
use Rector\NodeNameResolver\NodeNameResolver;

final class ConstructorFormControlTypeResolver implements FormControlTypeResolverInterface, MethodNamesByInputNamesResolverAwareInterface
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;

    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @var MethodNamesByInputNamesResolver
     */
    private $methodNamesByInputNamesResolver;

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

        if (! $this->nodeNameResolver->isName($node, MethodName::CONSTRUCT)) {
            return [];
        }

        $thisVariable = $this->betterNodeFinder->findVariableOfName($node, 'this');
        if (! $thisVariable instanceof Variable) {
            return [];
        }

        return $this->methodNamesByInputNamesResolver->resolveExpr($thisVariable);
    }

    /**
     * @return void
     */
    public function setResolver(MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver)
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }
}
