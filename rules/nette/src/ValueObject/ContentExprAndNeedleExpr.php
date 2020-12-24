<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Nette\ValueObject;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
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
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $contentExpr, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $needleExpr)
    {
        $this->contentExpr = $contentExpr;
        $this->needleExpr = $needleExpr;
    }
    public function getContentExpr() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        return $this->contentExpr;
    }
    public function getNeedleExpr() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        return $this->needleExpr;
    }
}
