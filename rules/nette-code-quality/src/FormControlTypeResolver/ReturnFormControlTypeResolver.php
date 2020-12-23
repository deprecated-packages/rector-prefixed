<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\FormControlTypeResolver;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface;
use _PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
final class ReturnFormControlTypeResolver implements \_PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface, \_PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var MethodNamesByInputNamesResolver
     */
    private $methodNamesByInputNamesResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->betterNodeFinder = $betterNodeFinder;
    }
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_) {
            return [];
        }
        if (!$node->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
            return [];
        }
        $initialAssign = $this->betterNodeFinder->findPreviousAssignToExpr($node->expr);
        if (!$initialAssign instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
            return [];
        }
        return $this->methodNamesByInputNamesResolver->resolveExpr($node);
    }
    public function setResolver(\_PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver) : void
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }
}
