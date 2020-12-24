<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PhpParser\Node\Stmt;

use _PhpScoper0a6b37af0871\PhpParser\Node;
class ElseIf_ extends \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt
{
    /** @var Node\Expr Condition */
    public $cond;
    /** @var Node\Stmt[] Statements */
    public $stmts;
    /**
     * Constructs an elseif node.
     *
     * @param Node\Expr   $cond       Condition
     * @param Node\Stmt[] $stmts      Statements
     * @param array       $attributes Additional attributes
     */
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $cond, array $stmts = [], array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->cond = $cond;
        $this->stmts = $stmts;
    }
    public function getSubNodeNames() : array
    {
        return ['cond', 'stmts'];
    }
    public function getType() : string
    {
        return 'Stmt_ElseIf';
    }
}
