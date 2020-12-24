<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php71\ValueObject;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
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
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $firstExpr, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $secondExpr)
    {
        $this->firstExpr = $firstExpr;
        $this->secondExpr = $secondExpr;
    }
    public function getFirstExpr() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        return $this->firstExpr;
    }
    public function getSecondExpr() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        return $this->secondExpr;
    }
}
