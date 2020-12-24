<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\FormControlTypeResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
final class AssignedVariablesMethodCallsFormTypeResolver implements \_PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface, \_PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var MethodNamesByInputNamesResolver
     */
    private $methodNamesByInputNamesResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->betterNodeFinder = $betterNodeFinder;
    }
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return [];
        }
        /** @var Assign|null $formVariableAssign */
        $formVariableAssign = $this->betterNodeFinder->findPreviousAssignToExpr($node);
        if ($formVariableAssign === null) {
            return [];
        }
        return $this->methodNamesByInputNamesResolver->resolveExpr($formVariableAssign->expr);
    }
    public function setResolver(\_PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver) : void
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }
}
