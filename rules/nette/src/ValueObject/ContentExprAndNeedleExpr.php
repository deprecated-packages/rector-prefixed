<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Nette\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
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
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Expr $contentExpr, \_PhpScopere8e811afab72\PhpParser\Node\Expr $needleExpr)
    {
        $this->contentExpr = $contentExpr;
        $this->needleExpr = $needleExpr;
    }
    public function getContentExpr() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        return $this->contentExpr;
    }
    public function getNeedleExpr() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        return $this->needleExpr;
    }
}
