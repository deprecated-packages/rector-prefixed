<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PhpParser\Node\Expr;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
class PreDec extends \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
{
    /** @var Expr Variable */
    public $var;
    /**
     * Constructs a pre decrement node.
     *
     * @param Expr  $var        Variable
     * @param array $attributes Additional attributes
     */
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $var, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->var = $var;
    }
    public function getSubNodeNames() : array
    {
        return ['var'];
    }
    public function getType() : string
    {
        return 'Expr_PreDec';
    }
}