<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Defluent\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface;
use _PhpScoperb75b35f52b74\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface;
final class FirstAssignFluentCall extends \_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\AbstractRootExpr implements \_PhpScoperb75b35f52b74\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface, \_PhpScoperb75b35f52b74\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface
{
    /**
     * @var FluentMethodCalls
     */
    private $fluentMethodCalls;
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $assignExpr, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $rootExpr, bool $isFirstCallFactory, \_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\FluentMethodCalls $fluentMethodCalls)
    {
        $this->assignExpr = $assignExpr;
        $this->rootExpr = $rootExpr;
        $this->isFirstCallFactory = $isFirstCallFactory;
        $this->fluentMethodCalls = $fluentMethodCalls;
    }
    public function getAssignExpr() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        return $this->assignExpr;
    }
    public function getRootExpr() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        return $this->rootExpr;
    }
    public function getCallerExpr() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        return $this->assignExpr;
    }
    public function isFirstCallFactory() : bool
    {
        return $this->isFirstCallFactory;
    }
    public function getFactoryAssignVariable() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
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
