<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Defluent\ValueObject;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface;
final class FirstAssignFluentCall extends \_PhpScoper2a4e7ab1ecbc\Rector\Defluent\ValueObject\AbstractRootExpr implements \_PhpScoper2a4e7ab1ecbc\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface, \_PhpScoper2a4e7ab1ecbc\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface
{
    /**
     * @var FluentMethodCalls
     */
    private $fluentMethodCalls;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $assignExpr, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $rootExpr, bool $isFirstCallFactory, \_PhpScoper2a4e7ab1ecbc\Rector\Defluent\ValueObject\FluentMethodCalls $fluentMethodCalls)
    {
        $this->assignExpr = $assignExpr;
        $this->rootExpr = $rootExpr;
        $this->isFirstCallFactory = $isFirstCallFactory;
        $this->fluentMethodCalls = $fluentMethodCalls;
    }
    public function getAssignExpr() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr
    {
        return $this->assignExpr;
    }
    public function getRootExpr() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr
    {
        return $this->rootExpr;
    }
    public function getCallerExpr() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr
    {
        return $this->assignExpr;
    }
    public function isFirstCallFactory() : bool
    {
        return $this->isFirstCallFactory;
    }
    public function getFactoryAssignVariable() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr
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
