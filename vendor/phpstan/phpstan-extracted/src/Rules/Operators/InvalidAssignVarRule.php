<?php

declare (strict_types=1);
namespace PHPStan\Rules\Operators;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\AssignOp;
use PhpParser\Node\Expr\AssignRef;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\NullsafeCheck;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Expr>
 */
class InvalidAssignVarRule implements \PHPStan\Rules\Rule
{
    /** @var NullsafeCheck */
    private $nullsafeCheck;
    public function __construct(\PHPStan\Rules\NullsafeCheck $nullsafeCheck)
    {
        $this->nullsafeCheck = $nullsafeCheck;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \PhpParser\Node\Expr\Assign && !$node instanceof \PhpParser\Node\Expr\AssignOp && !$node instanceof \PhpParser\Node\Expr\AssignRef) {
            return [];
        }
        if ($this->nullsafeCheck->containsNullSafe($node->var)) {
            return [\PHPStan\Rules\RuleErrorBuilder::message('Nullsafe operator cannot be on left side of assignment.')->nonIgnorable()->build()];
        }
        if ($node instanceof \PhpParser\Node\Expr\AssignRef && $this->nullsafeCheck->containsNullSafe($node->expr)) {
            return [\PHPStan\Rules\RuleErrorBuilder::message('Nullsafe operator cannot be on right side of assignment by reference.')->nonIgnorable()->build()];
        }
        if ($this->containsNonAssignableExpression($node->var)) {
            return [\PHPStan\Rules\RuleErrorBuilder::message('Expression on left side of assignment is not assignable.')->nonIgnorable()->build()];
        }
        return [];
    }
    private function containsNonAssignableExpression(\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \PhpParser\Node\Expr\Variable) {
            return \false;
        }
        if ($expr instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        if ($expr instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
            return \false;
        }
        if ($expr instanceof \PhpParser\Node\Expr\StaticPropertyFetch) {
            return \false;
        }
        if ($expr instanceof \PhpParser\Node\Expr\List_ || $expr instanceof \PhpParser\Node\Expr\Array_) {
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
