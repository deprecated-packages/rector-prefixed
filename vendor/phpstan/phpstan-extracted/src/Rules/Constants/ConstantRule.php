<?php

declare (strict_types=1);
namespace PHPStan\Rules\Constants;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\ConstFetch>
 */
class ConstantRule implements \PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\ConstFetch::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->hasConstant($node->name)) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Constant %s not found.', (string) $node->name))->discoveringSymbolsTip()->build()];
        }
        return [];
    }
}
