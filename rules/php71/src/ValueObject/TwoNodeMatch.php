<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php71\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
final class TwoNodeMatch
{
    /**
     * @var Expr
     */
    private $firstExpr;
    /**
     * @var Expr
     */
    private $secondExpr;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Expr $firstExpr, \_PhpScopere8e811afab72\PhpParser\Node\Expr $secondExpr)
    {
        $this->firstExpr = $firstExpr;
        $this->secondExpr = $secondExpr;
    }
    public function getFirstExpr() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        return $this->firstExpr;
    }
    public function getSecondExpr() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        return $this->secondExpr;
    }
}
