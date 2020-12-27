<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\DeadCode;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\UnreachableStatementNode;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\UnreachableStatementNode>
 */
class UnreachableStatementRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\UnreachableStatementNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->getOriginalStatement() instanceof \PhpParser\Node\Stmt\Nop) {
            return [];
        }
        return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message('Unreachable statement - code above always terminates.')->identifier('deadCode.unreachableStatement')->metadata(['depth' => $node->getAttribute('statementDepth'), 'order' => $node->getAttribute('statementOrder')])->build()];
    }
}
