<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Operators;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignRef;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\NullsafeCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Expr>
 */
class InvalidAssignVarRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var NullsafeCheck */
    private $nullsafeCheck;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\NullsafeCheck $nullsafeCheck)
    {
        $this->nullsafeCheck = $nullsafeCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign && !$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp && !$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignRef) {
            return [];
        }
        if ($this->nullsafeCheck->containsNullSafe($node->var)) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message('Nullsafe operator cannot be on left side of assignment.')->nonIgnorable()->build()];
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignRef && $this->nullsafeCheck->containsNullSafe($node->expr)) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message('Nullsafe operator cannot be on right side of assignment by reference.')->nonIgnorable()->build()];
        }
        if ($this->containsNonAssignableExpression($node->var)) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message('Expression on left side of assignment is not assignable.')->nonIgnorable()->build()];
        }
        return [];
    }
    private function containsNonAssignableExpression(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return \false;
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            return \false;
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch) {
            return \false;
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\List_ || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_) {
            foreach ($expr->items as $item) {
                if ($item === null) {
                    continue;
                }
                if (!$this->containsNonAssignableExpression($item->value)) {
                    continue;
                }
                return \true;
            }
            return \false;
        }
        return \true;
    }
}
