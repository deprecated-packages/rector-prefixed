<?php

declare (strict_types=1);
namespace PHPStan\Rules\Arrays;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\LiteralArrayNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\LiteralArrayNode>
 */
class EmptyArrayItemRule implements \PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PHPStan\Node\LiteralArrayNode::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        foreach ($node->getItemNodes() as $itemNode) {
            $item = $itemNode->getArrayItem();
            if ($item !== null) {
                continue;
            }
            return [\PHPStan\Rules\RuleErrorBuilder::message('Literal array contains empty item.')->nonIgnorable()->build()];
        }
        return [];
    }
}
