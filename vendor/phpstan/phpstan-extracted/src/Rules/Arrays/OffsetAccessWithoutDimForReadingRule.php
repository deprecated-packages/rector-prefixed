<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Arrays;

use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\ArrayDimFetch>
 */
class OffsetAccessWithoutDimForReadingRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\ArrayDimFetch::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if ($scope->isInExpressionAssign($node)) {
            return [];
        }
        if ($node->dim !== null) {
            return [];
        }
        return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message('Cannot use [] for reading.')->nonIgnorable()->build()];
    }
}
