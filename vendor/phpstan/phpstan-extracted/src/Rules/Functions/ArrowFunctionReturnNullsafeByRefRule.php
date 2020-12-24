<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Functions;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\NullsafeCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Node\Expr\ArrowFunction>
 */
class ArrowFunctionReturnNullsafeByRefRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var NullsafeCheck */
    private $nullsafeCheck;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\NullsafeCheck $nullsafeCheck)
    {
        $this->nullsafeCheck = $nullsafeCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrowFunction::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->byRef) {
            return [];
        }
        if (!$this->nullsafeCheck->containsNullSafe($node->expr)) {
            return [];
        }
        return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message('Nullsafe cannot be returned by reference.')->nonIgnorable()->build()];
    }
}
