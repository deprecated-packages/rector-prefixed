<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Operators;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignOp;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignRef;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\NullsafeCheck;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Expr>
 */
class InvalidAssignVarRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var NullsafeCheck */
    private $nullsafeCheck;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Rules\NullsafeCheck $nullsafeCheck)
    {
        $this->nullsafeCheck = $nullsafeCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign && !$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignOp && !$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignRef) {
            return [];
        }
        if ($this->nullsafeCheck->containsNullSafe($node->var)) {
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message('Nullsafe operator cannot be on left side of assignment.')->nonIgnorable()->build()];
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignRef && $this->nullsafeCheck->containsNullSafe($node->expr)) {
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message('Nullsafe operator cannot be on right side of assignment by reference.')->nonIgnorable()->build()];
        }
        if ($this->containsNonAssignableExpression($node->var)) {
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message('Expression on left side of assignment is not assignable.')->nonIgnorable()->build()];
        }
        return [];
    }
    private function containsNonAssignableExpression(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
            return \false;
        }
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch) {
            return \false;
        }
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticPropertyFetch) {
            return \false;
        }
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\List_ || $expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_) {
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
