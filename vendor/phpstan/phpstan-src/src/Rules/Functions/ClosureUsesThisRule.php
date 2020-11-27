<?php

declare (strict_types=1);
namespace PHPStan\Rules\Functions;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ThisType;
/**
 * @implements Rule<Node\Expr\Closure>
 */
class ClosureUsesThisRule implements \PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\Closure::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->static) {
            return [];
        }
        $messages = [];
        foreach ($node->uses as $closureUse) {
            $varType = $scope->getType($closureUse->var);
            if (!\is_string($closureUse->var->name)) {
                continue;
            }
            if (!$varType instanceof \PHPStan\Type\ThisType) {
                continue;
            }
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Anonymous function uses $this assigned to variable $%s. Use $this directly in the function body.', $closureUse->var->name))->line($closureUse->getLine())->build();
        }
        return $messages;
    }
}
