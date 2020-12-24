<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Arrays;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\LiteralArrayNode;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\LiteralArrayNode>
 */
class EmptyArrayItemRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Node\LiteralArrayNode::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        foreach ($node->getItemNodes() as $itemNode) {
            $item = $itemNode->getArrayItem();
            if ($item !== null) {
                continue;
            }
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message('Literal array contains empty item.')->nonIgnorable()->build()];
        }
        return [];
    }
}
