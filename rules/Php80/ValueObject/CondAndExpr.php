<?php

declare (strict_types=1);
namespace Rector\Php80\ValueObject;

use PhpParser\Node\Expr;
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
     * @var \PhpParser\Node\Expr|null
     */
    private $condExpr;
    /**
     * @var \PhpParser\Node\Expr
     */
    private $expr;
    /**
     * @var string
     */
    private $kind;
    public function __construct(?\PhpParser\Node\Expr $condExpr, \PhpParser\Node\Expr $expr, string $kind)
    {
        $this->condExpr = $condExpr;
        $this->expr = $expr;
        $this->kind = $kind;
    }
    public function getExpr() : \PhpParser\Node\Expr
    {
        return $this->expr;
    }
    public function getCondExpr() : ?\PhpParser\Node\Expr
    {
        return $this->condExpr;
    }
    public function getKind() : string
    {
        return $this->kind;
    }
}
