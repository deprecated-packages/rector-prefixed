<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Php71\ValueObject;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $firstExpr, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $secondExpr)
    {
        $this->firstExpr = $firstExpr;
        $this->secondExpr = $secondExpr;
    }
    public function getFirstExpr() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr
    {
        return $this->firstExpr;
    }
    public function getSecondExpr() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr
    {
        return $this->secondExpr;
    }
}
