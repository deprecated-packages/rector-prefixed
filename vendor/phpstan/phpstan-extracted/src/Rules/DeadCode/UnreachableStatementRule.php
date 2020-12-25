<?php

declare (strict_types=1);
namespace PHPStan\Rules\DeadCode;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\UnreachableStatementNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\UnreachableStatementNode>
 */
class UnreachableStatementRule implements \PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PHPStan\Node\UnreachableStatementNode::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->getOriginalStatement() instanceof \PhpParser\Node\Stmt\Nop) {
            return [];
        }
        return [\PHPStan\Rules\RuleErrorBuilder::message('Unreachable statement - code above always terminates.')->identifier('deadCode.unreachableStatement')->metadata(['depth' => $node->getAttribute('statementDepth'), 'order' => $node->getAttribute('statementOrder')])->build()];
    }
}
