<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php80\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
final class StrStartsWith
{
    /**
     * @var bool
     */
    private $isPositive = \false;
    /**
     * @var FuncCall
     */
    private $funcCall;
    /**
     * @var Expr
     */
    private $haystackExpr;
    /**
     * @var Expr
     */
    private $needleExpr;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScopere8e811afab72\PhpParser\Node\Expr $haystackExpr, \_PhpScopere8e811afab72\PhpParser\Node\Expr $needleExpr, bool $isPositive)
    {
        $this->funcCall = $funcCall;
        $this->haystackExpr = $haystackExpr;
        $this->isPositive = $isPositive;
        $this->needleExpr = $needleExpr;
    }
    public function getFuncCall() : \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall
    {
        return $this->funcCall;
    }
    public function getHaystackExpr() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        return $this->haystackExpr;
    }
    public function isPositive() : bool
    {
        return $this->isPositive;
    }
    public function getNeedleExpr() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        return $this->needleExpr;
    }
}
