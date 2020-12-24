<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\FormControlTypeResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
final class ClassMethodFormTypeResolver implements \_PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface, \_PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            return [];
        }
        if ($this->nodeNameResolver->isName($node, \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return [];
        }
        /** @var Return_|null $lastReturn */
        $lastReturn = $this->betterNodeFinder->findLastInstanceOf((array) $node->stmts, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_::class);
        if ($lastReturn === null) {
            return [];
        }
        if (!$lastReturn->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return [];
        }
        return $this->methodNamesByInputNamesResolver->resolveExpr($lastReturn->expr);
    }
    public function setResolver(\_PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver) : void
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }
}
