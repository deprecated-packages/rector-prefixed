<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $haystackExpr, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $needleExpr, bool $isPositive)
    {
        $this->funcCall = $funcCall;
        $this->haystackExpr = $haystackExpr;
        $this->isPositive = $isPositive;
        $this->needleExpr = $needleExpr;
    }
    public function getFuncCall() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall
    {
        return $this->funcCall;
    }
    public function getHaystackExpr() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr
    {
        return $this->haystackExpr;
    }
    public function isPositive() : bool
    {
        return $this->isPositive;
    }
    public function getNeedleExpr() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr
    {
        return $this->needleExpr;
    }
}
