<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Defluent\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface;
use _PhpScoperb75b35f52b74\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface;
final class AssignAndRootExpr extends \_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\AbstractRootExpr implements \_PhpScoperb75b35f52b74\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface, \_PhpScoperb75b35f52b74\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface
{
    /**
     * @var Variable|null
     */
    private $silentVariable;
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $assignExpr, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $rootExpr, ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $silentVariable = null, bool $isFirstCallFactory = \false)
    {
        $this->assignExpr = $assignExpr;
        $this->rootExpr = $rootExpr;
        $this->silentVariable = $silentVariable;
        $this->isFirstCallFactory = $isFirstCallFactory;
    }
    public function getAssignExpr() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        return $this->assignExpr;
    }
    public function getRootExpr() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        return $this->rootExpr;
    }
    public function getSilentVariable() : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable
    {
        return $this->silentVariable;
    }
    public function getReturnSilentVariable() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_
    {
        if ($this->silentVariable === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_($this->silentVariable);
    }
    public function getCallerExpr() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
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
    public function getFactoryAssignVariable() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        $firstAssign = $this->getFirstAssign();
        if ($firstAssign === null) {
            return $this->getCallerExpr();
        }
        return $firstAssign->var;
    }
}
