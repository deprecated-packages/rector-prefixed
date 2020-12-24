<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Defluent\ValueObject;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface;
use _PhpScoper0a6b37af0871\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface;
final class FirstAssignFluentCall extends \_PhpScoper0a6b37af0871\Rector\Defluent\ValueObject\AbstractRootExpr implements \_PhpScoper0a6b37af0871\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface, \_PhpScoper0a6b37af0871\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface
{
    /**
     * @var FluentMethodCalls
     */
    private $fluentMethodCalls;
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $assignExpr, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $rootExpr, bool $isFirstCallFactory, \_PhpScoper0a6b37af0871\Rector\Defluent\ValueObject\FluentMethodCalls $fluentMethodCalls)
    {
        $this->assignExpr = $assignExpr;
        $this->rootExpr = $rootExpr;
        $this->isFirstCallFactory = $isFirstCallFactory;
        $this->fluentMethodCalls = $fluentMethodCalls;
    }
    public function getAssignExpr() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        return $this->assignExpr;
    }
    public function getRootExpr() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        return $this->rootExpr;
    }
    public function getCallerExpr() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        return $this->assignExpr;
    }
    public function isFirstCallFactory() : bool
    {
        return $this->isFirstCallFactory;
    }
    public function getFactoryAssignVariable() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
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
