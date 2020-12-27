<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Constants;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\ConstFetch>
 */
class ConstantRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\ConstFetch::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->hasConstant($node->name)) {
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Constant %s not found.', (string) $node->name))->discoveringSymbolsTip()->build()];
        }
        return [];
    }
}
