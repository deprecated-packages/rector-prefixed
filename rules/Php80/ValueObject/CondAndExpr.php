<?php

declare (strict_types=1);
namespace Rector\Php80\ValueObject;

use PhpParser\Node\Expr;
final class CondAndExpr
{
    /**
     * @var string
     */
    const TYPE_NORMAL = 'normal';
    /**
     * @var string
     */
    const TYPE_ASSIGN = 'assign';
    /**
     * @var string
     */
    const TYPE_RETURN = 'return';
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
    /**
     * @param \PhpParser\Node\Expr|null $condExpr
     */
    public function __construct($condExpr, \PhpParser\Node\Expr $expr, string $kind)
    {
        $this->condExpr = $condExpr;
        $this->expr = $expr;
        $this->kind = $kind;
    }
    public function getExpr() : \PhpParser\Node\Expr
    {
        return $this->expr;
    }
    /**
     * @return \PhpParser\Node\Expr|null
     */
    public function getCondExpr()
    {
        return $this->condExpr;
    }
    public function getKind() : string
    {
        return $this->kind;
    }
}
