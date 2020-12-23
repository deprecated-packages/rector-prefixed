<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php80\ValueObject;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
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
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $haystackExpr, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $needleExpr, bool $isPositive)
    {
        $this->funcCall = $funcCall;
        $this->haystackExpr = $haystackExpr;
        $this->isPositive = $isPositive;
        $this->needleExpr = $needleExpr;
    }
    public function getFuncCall() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall
    {
        return $this->funcCall;
    }
    public function getHaystackExpr() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        return $this->haystackExpr;
    }
    public function isPositive() : bool
    {
        return $this->isPositive;
    }
    public function getNeedleExpr() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        return $this->needleExpr;
    }
}
