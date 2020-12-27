<?php

declare (strict_types=1);
namespace PHPStan\Rules\Arrays;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Foreach_>
 */
class DeadForeachRule implements \PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\Foreach_::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $iterableType = $scope->getType($node->expr);
        if ($iterableType->isIterable()->no()) {
            return [];
        }
        if (!$iterableType->isIterableAtLeastOnce()->no()) {
            return [];
        }
        return [\PHPStan\Rules\RuleErrorBuilder::message('Empty array passed to foreach.')->build()];
    }
}
