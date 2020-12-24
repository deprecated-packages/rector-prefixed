<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface;
use _PhpScopere8e811afab72\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface;
final class AssignAndRootExpr extends \_PhpScopere8e811afab72\Rector\Defluent\ValueObject\AbstractRootExpr implements \_PhpScopere8e811afab72\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface, \_PhpScopere8e811afab72\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface
{
    /**
     * @var Variable|null
     */
    private $silentVariable;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Expr $assignExpr, \_PhpScopere8e811afab72\PhpParser\Node\Expr $rootExpr, ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $silentVariable = null, bool $isFirstCallFactory = \false)
    {
        $this->assignExpr = $assignExpr;
        $this->rootExpr = $rootExpr;
        $this->silentVariable = $silentVariable;
        $this->isFirstCallFactory = $isFirstCallFactory;
    }
    public function getAssignExpr() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        return $this->assignExpr;
    }
    public function getRootExpr() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        return $this->rootExpr;
    }
    public function getSilentVariable() : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable
    {
        return $this->silentVariable;
    }
    public function getReturnSilentVariable() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_
    {
        if ($this->silentVariable === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_($this->silentVariable);
    }
    public function getCallerExpr() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
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
    public function getFactoryAssignVariable() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        $firstAssign = $this->getFirstAssign();
        if ($firstAssign === null) {
            return $this->getCallerExpr();
        }
        return $firstAssign->var;
    }
}
