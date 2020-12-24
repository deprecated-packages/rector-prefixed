<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php80\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
final class CondAndExpr
{
    /**
     * @var string
     */
    public const TYPE_NORMAL = 'normal';
    /**
     * @var string
     */
    public const TYPE_ASSIGN = 'assign';
    /**
     * @var string
     */
    public const TYPE_RETURN = 'return';
    /**
     * @var string
     */
    private $kind;
    /**
     * @var Expr
     */
    private $expr;
    /**
     * @var Expr|null
     */
    private $condExpr;
    public function __construct(?\_PhpScopere8e811afab72\PhpParser\Node\Expr $condExpr, \_PhpScopere8e811afab72\PhpParser\Node\Expr $expr, string $kind)
    {
        $this->condExpr = $condExpr;
        $this->expr = $expr;
        $this->kind = $kind;
    }
    public function getExpr() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        return $this->expr;
    }
    public function getCondExpr() : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        return $this->condExpr;
    }
    public function getKind() : string
    {
        return $this->kind;
    }
}
