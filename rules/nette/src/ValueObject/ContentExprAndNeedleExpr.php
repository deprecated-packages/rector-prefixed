<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Nette\ValueObject;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $contentExpr, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $needleExpr)
    {
        $this->contentExpr = $contentExpr;
        $this->needleExpr = $needleExpr;
    }
    public function getContentExpr() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr
    {
        return $this->contentExpr;
    }
    public function getNeedleExpr() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr
    {
        return $this->needleExpr;
    }
}
