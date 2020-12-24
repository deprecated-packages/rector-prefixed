<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php80\ValueObject;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
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
    public function __construct(?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $condExpr, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr, string $kind)
    {
        $this->condExpr = $condExpr;
        $this->expr = $expr;
        $this->kind = $kind;
    }
    public function getExpr() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        return $this->expr;
    }
    public function getCondExpr() : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        return $this->condExpr;
    }
    public function getKind() : string
    {
        return $this->kind;
    }
}
