<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php71\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
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
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $firstExpr, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $secondExpr)
    {
        $this->firstExpr = $firstExpr;
        $this->secondExpr = $secondExpr;
    }
    public function getFirstExpr() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        return $this->firstExpr;
    }
    public function getSecondExpr() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        return $this->secondExpr;
    }
}
