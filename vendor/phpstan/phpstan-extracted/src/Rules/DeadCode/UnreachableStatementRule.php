<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\DeadCode;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\UnreachableStatementNode;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\UnreachableStatementNode>
 */
class UnreachableStatementRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Node\UnreachableStatementNode::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->getOriginalStatement() instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Nop) {
            return [];
        }
        return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message('Unreachable statement - code above always terminates.')->identifier('deadCode.unreachableStatement')->metadata(['depth' => $node->getAttribute('statementDepth'), 'order' => $node->getAttribute('statementOrder')])->build()];
    }
}
