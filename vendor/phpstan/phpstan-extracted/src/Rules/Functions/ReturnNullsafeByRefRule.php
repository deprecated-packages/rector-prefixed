<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Functions;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\ReturnStatementsNode;
use _PhpScopere8e811afab72\PHPStan\Rules\NullsafeCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<ReturnStatementsNode>
 */
class ReturnNullsafeByRefRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var NullsafeCheck */
    private $nullsafeCheck;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\NullsafeCheck $nullsafeCheck)
    {
        $this->nullsafeCheck = $nullsafeCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Node\ReturnStatementsNode::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->returnsByRef()) {
            return [];
        }
        $errors = [];
        foreach ($node->getReturnStatements() as $returnStatement) {
            $returnNode = $returnStatement->getReturnNode();
            if ($returnNode->expr === null) {
                continue;
            }
            if (!$this->nullsafeCheck->containsNullSafe($returnNode->expr)) {
                continue;
            }
            $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message('Nullsafe cannot be returned by reference.')->line($returnNode->getLine())->nonIgnorable()->build();
        }
        return $errors;
    }
}
