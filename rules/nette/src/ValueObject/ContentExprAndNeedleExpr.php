<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Nette\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
final class ContentExprAndNeedleExpr
{
    /**
     * @var Expr
     */
    private $contentExpr;
    /**
     * @var Expr
     */
    private $needleExpr;
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $contentExpr, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $needleExpr)
    {
        $this->contentExpr = $contentExpr;
        $this->needleExpr = $needleExpr;
    }
    public function getContentExpr() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        return $this->contentExpr;
    }
    public function getNeedleExpr() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        return $this->needleExpr;
    }
}
