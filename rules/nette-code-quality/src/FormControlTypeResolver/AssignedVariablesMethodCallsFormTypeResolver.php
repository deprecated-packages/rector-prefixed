<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\FormControlTypeResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface;
use _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
final class AssignedVariablesMethodCallsFormTypeResolver implements \_PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface, \_PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Contract\MethodNamesByInputNamesResolverAwareInterface
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var MethodNamesByInputNamesResolver
     */
    private $methodNamesByInputNamesResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->betterNodeFinder = $betterNodeFinder;
    }
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return [];
        }
        /** @var Assign|null $formVariableAssign */
        $formVariableAssign = $this->betterNodeFinder->findPreviousAssignToExpr($node);
        if ($formVariableAssign === null) {
            return [];
        }
        return $this->methodNamesByInputNamesResolver->resolveExpr($formVariableAssign->expr);
    }
    public function setResolver(\_PhpScoperb75b35f52b74\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver) : void
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
    }
}
