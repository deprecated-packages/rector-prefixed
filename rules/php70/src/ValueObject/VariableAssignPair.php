<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php70\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignRef;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
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
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node $variable, \_PhpScopere8e811afab72\PhpParser\Node $node)
    {
        $this->variable = $variable;
        $this->assign = $node;
    }
    /**
     * @return Variable|ArrayDimFetch|PropertyFetch|StaticPropertyFetch
     */
    public function getVariable() : \_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->variable;
    }
    /**
     * @return Assign|AssignOp|AssignRef
     */
    public function getAssign() : \_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->assign;
    }
}
