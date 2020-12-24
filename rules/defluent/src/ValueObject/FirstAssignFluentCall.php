<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface;
use _PhpScopere8e811afab72\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface;
final class FirstAssignFluentCall extends \_PhpScopere8e811afab72\Rector\Defluent\ValueObject\AbstractRootExpr implements \_PhpScopere8e811afab72\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface, \_PhpScopere8e811afab72\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface
{
    /**
     * @var FluentMethodCalls
     */
    private $fluentMethodCalls;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Expr $assignExpr, \_PhpScopere8e811afab72\PhpParser\Node\Expr $rootExpr, bool $isFirstCallFactory, \_PhpScopere8e811afab72\Rector\Defluent\ValueObject\FluentMethodCalls $fluentMethodCalls)
    {
        $this->assignExpr = $assignExpr;
        $this->rootExpr = $rootExpr;
        $this->isFirstCallFactory = $isFirstCallFactory;
        $this->fluentMethodCalls = $fluentMethodCalls;
    }
    public function getAssignExpr() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        return $this->assignExpr;
    }
    public function getRootExpr() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        return $this->rootExpr;
    }
    public function getCallerExpr() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        return $this->assignExpr;
    }
    public function isFirstCallFactory() : bool
    {
        return $this->isFirstCallFactory;
    }
    public function getFactoryAssignVariable() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        $firstAssign = $this->getFirstAssign();
        if ($firstAssign === null) {
            return $this->assignExpr;
        }
        return $firstAssign->var;
    }
    /**
     * @return MethodCall[]
     */
    public function getFluentMethodCalls() : array
    {
        return $this->fluentMethodCalls->getFluentMethodCalls();
    }
}
