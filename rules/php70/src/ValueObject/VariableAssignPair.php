<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php70\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignRef;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
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
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node $variable, \_PhpScoperb75b35f52b74\PhpParser\Node $node)
    {
        $this->variable = $variable;
        $this->assign = $node;
    }
    /**
     * @return Variable|ArrayDimFetch|PropertyFetch|StaticPropertyFetch
     */
    public function getVariable() : \_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return $this->variable;
    }
    /**
     * @return Assign|AssignOp|AssignRef
     */
    public function getAssign() : \_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return $this->assign;
    }
}
