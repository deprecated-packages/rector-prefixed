<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Defluent\ValueObject;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface;
use _PhpScoper0a6b37af0871\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface;
final class AssignAndRootExpr extends \_PhpScoper0a6b37af0871\Rector\Defluent\ValueObject\AbstractRootExpr implements \_PhpScoper0a6b37af0871\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface, \_PhpScoper0a6b37af0871\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface
{
    /**
     * @var Variable|null
     */
    private $silentVariable;
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $assignExpr, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $rootExpr, ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $silentVariable = null, bool $isFirstCallFactory = \false)
    {
        $this->assignExpr = $assignExpr;
        $this->rootExpr = $rootExpr;
        $this->silentVariable = $silentVariable;
        $this->isFirstCallFactory = $isFirstCallFactory;
    }
    public function getAssignExpr() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        return $this->assignExpr;
    }
    public function getRootExpr() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        return $this->rootExpr;
    }
    public function getSilentVariable() : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable
    {
        return $this->silentVariable;
    }
    public function getReturnSilentVariable() : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_
    {
        if ($this->silentVariable === null) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_($this->silentVariable);
    }
    public function getCallerExpr() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        if ($this->silentVariable !== null) {
            return $this->silentVariable;
        }
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
            return $this->getCallerExpr();
        }
        return $firstAssign->var;
    }
}
