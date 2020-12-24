<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Constants;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\ConstFetch>
 */
class ConstantRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->hasConstant($node->name)) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Constant %s not found.', (string) $node->name))->discoveringSymbolsTip()->build()];
        }
        return [];
    }
}
