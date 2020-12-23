<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php70\ValueObject;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\AssignOp;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\AssignRef;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
final class VariableAssignPair
{
    /**
     * @var Variable|ArrayDimFetch|PropertyFetch|StaticPropertyFetch
     */
    private $variable;
    /**
     * @var Assign|AssignOp|AssignRef
     */
    private $assign;
    /**
     * @param Variable|ArrayDimFetch|PropertyFetch|StaticPropertyFetch $variable
     * @param Assign|AssignOp|AssignRef $node
     */
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\Node $variable, \_PhpScoper0a2ac50786fa\PhpParser\Node $node)
    {
        $this->variable = $variable;
        $this->assign = $node;
    }
    /**
     * @return Variable|ArrayDimFetch|PropertyFetch|StaticPropertyFetch
     */
    public function getVariable() : \_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        return $this->variable;
    }
    /**
     * @return Assign|AssignOp|AssignRef
     */
    public function getAssign() : \_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        return $this->assign;
    }
}
