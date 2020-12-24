<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
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
    public function __construct(?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $condExpr, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $expr, string $kind)
    {
        $this->condExpr = $condExpr;
        $this->expr = $expr;
        $this->kind = $kind;
    }
    public function getExpr() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr
    {
        return $this->expr;
    }
    public function getCondExpr() : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr
    {
        return $this->condExpr;
    }
    public function getKind() : string
    {
        return $this->kind;
    }
}
